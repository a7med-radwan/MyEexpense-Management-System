<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Plan;
use App\Services\OpenAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    protected $openAiService;

    public function __construct(OpenAIService $openAiService)
    {
        $this->openAiService = $openAiService;
    }

    public function index()
    {
        $plans = Auth::user()->plans()->orderBy('created_at', 'desc')->get();
        return view('plans.index', compact('plans'));
    }

    public function show(Plan $plan)
    {
        if ($plan->user_id !== Auth::id()) {
            abort(403);
        }

        $planData = $plan->plan_data;
        return view('plans.show', compact('plan', 'planData'));
    }

    public function create()
    {
        return view('plans.create');
    }

    public function generate(Request $request)
    {

        $month = $request->input('month', date('Y-m'));
        $user = Auth::user();

        $income = $user->incomes()->where('month', $month)->sum('amount');

        $categories = $user->categories()->where('month', $month)->with([
            'expenses' => function ($q) use ($month) {
                $q->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$month]);
            }
        ])->get();

        $totalExpenses = 0;
        foreach ($categories as $cat) {
            $totalExpenses += $cat->expenses->sum('amount');
        }

        if ($income <= 0 || $totalExpenses <= 0) {
            $message = 'لا يمكن توليد خطة لهذا الشهر. يجب أن يكون هناك دخل ومصروفات مسجلة أولاً.';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return back()->with('error', $message);
        }

        $categoriesData = $categories->map(function ($cat) {
            return [
                'name' => $cat->name,
                'expected_amount' => $cat->expected_amount,
                'spent_amount' => $cat->expenses->sum('amount')
            ];
        })->toArray();

        $currentData = [
            'income' => $income,
            'categories' => $categoriesData
        ];

        $suggestedPlan = $this->openAiService->generatePlan($currentData);

        if ($suggestedPlan) {
            $plan = Auth::user()->plans()->create([
                'month' => $month,
                'plan_data' => $suggestedPlan
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect_url' => route('plans.show', $plan)
                ]);
            }

            return redirect()->route('plans.show', $plan)->with('success', 'تم إنشاء الخطة المقترحة بنجاح بواسطة OpenAI.');
        } else {
            $errorMsg = 'فشل الاتصال بخدمة OpenAI. تأكد من إعدادات API Key.';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $errorMsg], 500);
            }
            return back()->with('error', $errorMsg);
        }
    }

    public function update(Request $request, Plan $plan)
    {
        if ($plan->user_id !== Auth::id()) {
            abort(403);
        }

        $planData = $plan->plan_data;
        $month = $plan->month;

        foreach ($planData as $item) {
            $category = Auth::user()->categories()
                ->where('month', $month)
                ->where('name', $item['name'])
                ->first();

            if ($category) {
                $category->update(['expected_amount' => $item['suggested_amount']]);
            } else {
                Auth::user()->categories()->create([
                    'name' => $item['name'],
                    'expected_amount' => $item['suggested_amount'],
                    'month' => $month
                ]);
            }
        }

        return redirect()->route('categories.index', ['month' => $month])
            ->with('updated', 'تم تعديل الميزانية بناءً على الخطة المقترحة');
    }

    public function destroy(Plan $plan)
    {
        if ($plan->user_id !== Auth::id())
            abort(403);
        $plan->delete();
        return back()->with('deleted', 'تم الحذف بنجاح');
    }
}

