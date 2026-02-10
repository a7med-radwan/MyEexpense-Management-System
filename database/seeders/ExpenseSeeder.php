<?php

namespace Database\Seeders;

use App\Models\Expense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() {
        Expense::create([
            'user_id' => 1, 'category_id' => 1,// طعام
            'amount' => 50, 'date' => '2026-01-10',
            ]);

        Expense::create([
            'user_id' => 1, 'category_id' => 3,// مواصلات
            'amount' => 20, 'date' => '2026-01-11',
            ]);
    }


}
