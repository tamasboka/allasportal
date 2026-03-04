<?php

namespace Database\Seeders;

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
            CategoriesSeeder::class,
            JobApplicationSeeder::class,
            JobCategorySeeder::class,
            JobSeeder::class,
            NotificationSeeder::class,
            OrganizationsSeeder::class,
            RatingSeeder::class,
            RequiredSkillSeeder::class,
            SkillSeeder::class,
            UserOrganizationSeeder::class,
            UserSavedJobSeeder::class,
            UserSkillSeeder::class,
            UserSeeder::class,
        ]);
    }
}
