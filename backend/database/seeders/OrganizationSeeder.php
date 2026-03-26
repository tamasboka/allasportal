<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organization::create([
            'name' => 'JobNest',
            'founded_at' => now()
        ]);

        DB::table('organization_user')->insert([
            'organization_id' => 1,
            'user_id' => 1,
        ]);
        DB::table('organization_user')->insert([
            'organization_id' => 1,
            'user_id' => 2,
        ]);
    }
}
