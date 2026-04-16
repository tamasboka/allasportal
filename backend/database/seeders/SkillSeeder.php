<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Skill::create(['name' => 'PHP (Laravel)']);
        Skill::create(['name' => 'JavaScript (React/Vue)']);
        Skill::create(['name' => 'Python']);
        Skill::create(['name' => 'Docker & Kubernetes']);
        Skill::create(['name' => 'SQL & NoSQL']);
        Skill::create(['name' => 'Figma']);
        Skill::create(['name' => 'Bérszámfejtés']);
        Skill::create(['name' => 'Projektmenedzsment']);
        Skill::create(['name' => 'Pénzügyi elemzés']);
        Skill::create(['name' => 'Munkajogi ismeretek']);
        Skill::create(['name' => 'Tárgyalástechnika']);
        Skill::create(['name' => 'Google Ads / Facebook Ads']);
        Skill::create(['name' => 'SEO optimalizálás']);
        Skill::create(['name' => 'Adobe Creative Cloud']);
        Skill::create(['name' => 'Copywriting']);
        Skill::create(['name' => 'CRM rendszerek kezelése']);
        Skill::create(['name' => 'Raktárkezelés']);
        Skill::create(['name' => 'Targoncavezetői jogosítvány']);
        Skill::create(['name' => 'Minőségbiztosítás']);
        Skill::create(['name' => 'Beszerzési ismeretek']);
        Skill::create(['name' => 'CAD tervezés']);
        Skill::create(['name' => 'Idegen nyelv oktatás']);
        Skill::create(['name' => 'Szakápolói ismeretek']);
        Skill::create(['name' => 'Előadástechnika']);
        Skill::create(['name' => 'Elsősegélynyújtás']);
    }
}
