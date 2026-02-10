<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $month = $request->input('month', date('Y-m'));
        $currentMonth = date('Y-m');

        if ($month > $currentMonth) {
            return redirect()->route('categories.index', ['month' => $currentMonth])
                ->with('error', "عذراً، لا يمكن استعراض أو تنفيذ عمليات مستقبلية. نحن لا نزال في شهر {$currentMonth} الحالي.");
        }

        $categories = Auth::user()->categories()
            ->where('month', $month)
            ->with([
                'expenses' => function ($q) use ($month) {
                    $q->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$month]);
                }
            ])
            ->get()
            ->each(function ($category) {
                $category->spent_amount = $category->expenses->sum('amount');
                $category->remaining_amount = $category->expected_amount - $category->spent_amount;
            });

        return view('categories.index', compact('categories', 'month', 'currentMonth'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'expected_amount' => 'required|numeric|min:0',
            'month' => 'required|date_format:Y-m',
        ]);

        if ($request->month !== date('Y-m')) {
            return back()->with('error', 'يمكن إضافة التصنيف للشهر الحالي فقط.');
        }

        Auth::user()->categories()->create($request->all());

        return redirect()->route('categories.index', ['month' => $request->month])
            ->with('success', 'تم الإضافة بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'expected_amount' => 'required|numeric|min:0',
            'month' => 'required|date_format:Y-m',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index', ['month' => $category->month])
            ->with('updated', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }

        $month = $category->month;
        $category->delete();

        return redirect()->route('categories.index', ['month' => $month])
            ->with('deleted', 'تم الحذف بنجاح');
    }
}
