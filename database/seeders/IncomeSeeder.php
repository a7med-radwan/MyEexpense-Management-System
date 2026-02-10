<?php

namespace Database\Seeders;

use App\Models\Income;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() {
        Income::create([
            'user_id' => 1, 'amount' => 3000, 'source' => 'راتب شهري', 'month' => '2026-01',
            ]);
        Income::create([
            'user_id' => 1, 'amount' => 500, 'source' => 'عمل حر', 'month' => '2026-01',
            ]);
    }
}
