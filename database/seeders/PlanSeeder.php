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
    public function run(): void
    {
        Plan::create([
            'user_id' => 1,
            'title' => 'beli batre laptop',
            'target' => 500000,
            'target_date' => '2025-01-01'
        ]);
    }
}
