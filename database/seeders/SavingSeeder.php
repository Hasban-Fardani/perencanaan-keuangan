<?php

namespace Database\Seeders;

use App\Models\Saving;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SavingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Saving::create([
            'plan_id' => 1,
            'amount' => 10000,
        ]);

        Saving::create([
            'plan_id' => 1,
            'amount' => 10000,
            'created_at' => now()->subDay(1)
        ]);

        Saving::create([
            'plan_id' => 1,
            'amount' => 10000,
            'created_at' => now()->subDay(1)
        ]);
    }
}
