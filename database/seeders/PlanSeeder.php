<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() {
        Plan::create([
            'user_id' => 1,
            'month' => '2026-01',
            'plan_data' => json_encode([
                'طعام' => 900,
                'مسكن' => 1200,
                'مواصلات' => 350,
                'علاج' => 300,
                ]),
            ]);
    }
}
