<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $month = $request->input('month', date('Y-m'));
        $currentMonth = date('Y-m');

        if ($month > $currentMonth) {
            return redirect()->route('incomes.index', ['month' => $currentMonth])
                ->with('error', "عذراً، لا يمكن استعراض أو تنفيذ عمليات مستقبلية. نحن لا نزال في شهر {$currentMonth} الحالي.");
        }

        $incomes = Auth::user()->incomes()->where('month', $month)->get();
        return view('incomes.index', compact('incomes', 'month', 'currentMonth'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('incomes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'source' => 'required|string|max:255',
            'month' => 'required|date_format:Y-m',
        ]);

        if ($request->month !== date('Y-m')) {
            return back()->with('error', 'يمكن إضافة الدخل للشهر الحالي فقط.');
        }

        Auth::user()->incomes()->create($request->all());

        return redirect()->route('incomes.index', ['month' => $request->month])
            ->with('success', 'تم الإضافة بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Income $income)
    {
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }
        return view('incomes.edit', compact('income'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0',
            'source' => 'required|string|max:255',
            'month' => 'required|date_format:Y-m',
        ]);

        $income->update($request->all());

        return redirect()->route('incomes.index', ['month' => $request->month])
            ->with('updated', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }

        $month = $income->month;
        $income->delete();

        return redirect()->route('incomes.index', ['month' => $month])
            ->with('deleted', 'تم الحذف بنجاح');
    }
}
