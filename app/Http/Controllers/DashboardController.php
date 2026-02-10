<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', date('Y-m'));
        $currentMonth = date('Y-m');

        if ($month > $currentMonth) {
            return redirect()->route('dashboard', ['month' => $currentMonth])
                ->with('error', "عذراً، لا يمكن استعراض أو تنفيذ عمليات مستقبلية. نحن لا نزال في شهر {$currentMonth} الحالي.");
        }

        $user = Auth::user();

        $totalIncome = $user->incomes()->where('month', $month)->sum('amount');

        $categories = $user->categories()->where('month', $month)->with([
            'expenses' => function ($query) use ($month) {
                $query->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$month]);
            }
        ])->get();

        $categoryData = $categories->map(function ($category) {
            $spent = $category->expenses->sum('amount');
            $remaining = $category->expected_amount - $spent;
            return [
                'name' => $category->name,
                'expected' => $category->expected_amount,
                'spent' => $spent,
                'remaining' => $remaining,
                'status' => $remaining < 0 ? 'over_budget' : 'good'
            ];
        });

        $totalBudgeted = $categories->sum('expected_amount');
        $totalSpent = $categories->sum(function ($cat) {
            return $cat->expenses->sum('amount');
        });


        $totalRemaining = $totalIncome - $totalSpent;

        return view('dashboard', compact('month', 'totalIncome', 'totalBudgeted', 'totalSpent', 'totalRemaining', 'categoryData'));
    }
}
