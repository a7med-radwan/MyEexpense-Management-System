<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $month = $request->input('month', date('Y-m'));
        $currentMonth = date('Y-m');

        if ($month > $currentMonth) {
            return redirect()->route('expenses.index', ['month' => $currentMonth])
                ->with('error', "عذراً، لا يمكن استعراض أو تنفيذ عمليات مستقبلية. نحن لا نزال في شهر {$currentMonth} الحالي.");
        }

        $expenses = Auth::user()->expenses()
            ->whereHas('category')
            ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$month])
            ->with('category')
            ->orderBy('date', 'desc')
            ->get();

        return view('expenses.index', compact('expenses', 'month', 'currentMonth'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentMonth = date('Y-m');
        $categories = Auth::user()->categories()->where('month', $currentMonth)->get();

        return view('expenses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentMonth = date('Y-m');

        $request->validate([
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where(function ($query) use ($currentMonth) {
                    return $query->where('user_id', Auth::id())->where('month', $currentMonth);
                }),
            ],
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date|date_format:Y-m-d|before_or_equal:today|after_or_equal:first day of this month',
        ], [
            'date.after_or_equal' => 'يجب أن يكون التاريخ ضمن الشهر الحالي فقط.',
            'date.before_or_equal' => 'لا يمكن تسجيل مصروفات في تاريخ مستقبلي.',
        ]);

        Auth::user()->expenses()->create($request->all());

        return redirect()->route('expenses.index', ['month' => $currentMonth])
            ->with('success', 'تم الإضافة بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        // Allow editing category to one that matches the expense month or all? 
        // Let's show all user categories to avoid locking them out if they made a mistake.
        $categories = Auth::user()->categories;

        return view('expenses.edit', compact('expense', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                }),
            ],
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $expense->update($request->all());

        return redirect()->route('expenses.index', ['month' => date('Y-m', strtotime($expense->date))])
            ->with('updated', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $month = date('Y-m', strtotime($expense->date));
        $expense->delete();

        return redirect()->route('expenses.index', ['month' => $month])
            ->with('deleted', 'تم الحذف بنجاح');
    }
}
