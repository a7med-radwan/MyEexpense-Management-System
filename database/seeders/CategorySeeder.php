<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() {
        $categories = [
            ['name' => 'طعام', 'expected_amount' => 1000],
            ['name' => 'مسكن', 'expected_amount' => 1200],
            ['name' => 'مواصلات', 'expected_amount' => 400],
            ['name' => 'علاج', 'expected_amount' => 300], ];

        foreach ($categories as $cat) {
            Category::create([
                'user_id' => 1, 'name' => $cat['name'],
                'expected_amount' => $cat['expected_amount'],
                'month' => '2026-01',
                ]);
        }
    }
}
