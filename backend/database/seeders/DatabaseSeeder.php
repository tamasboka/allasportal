<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RatingSeeder::class,
            NotificationSeeder::class,
            OrganizationSeeder::class,
            SkillSeeder::class,
            CategorySeeder::class,
            JobSeeder::class,
            JobApplicationSeeder::class,
        ]);
    }
}
