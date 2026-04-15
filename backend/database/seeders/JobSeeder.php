<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Job::create([
            'user_id' => 1,
            'name' => 'Frontend programozó',
            'job_type' => 'programmer',
            'min_salary' => 10000,
            'max_salary' => 670000,
            'capacity' => 10,
            'location' => 'Hungary',
            'has_home_office' => 1,
            'type' => 'part-time'
        ]);
        Job::create([
            'user_id' => 2,
            'name' => 'aaaeaeeaeaarraar',
            'job_type' => 'nem tudom',
            'min_salary' => 5000,
            'max_salary' => 10000,
            'capacity' => 67,
            'location' => 'Hungary',
            'has_home_office' => 0,
            'type' => 'full-time'
        ]);
    }
}
