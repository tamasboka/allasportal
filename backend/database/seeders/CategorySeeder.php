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
    public function run(): void
    {
        Category::create(['name' => 'Szoftverfejlesztés']);
        Category::create(['name' => 'Adattudomány és Mesterséges Intelligencia']);
        Category::create(['name' => 'Rendszergazda és Felhőkezelés']);
        Category::create(['name' => 'Kiberbiztonság']);
        Category::create(['name' => 'UI/UX Design']);
        Category::create(['name' => 'Pénzügy és Könyvelés']);
        Category::create(['name' => 'Emberi Erőforrások (HR)']);
        Category::create(['name' => 'Adminisztráció és Asszisztencia']);
        Category::create(['name' => 'Jog és Megfelelőség']);
        Category::create(['name' => 'Bank és Biztosítás']);
        Category::create(['name' => 'Marketing és Kommunikáció']);
        Category::create(['name' => 'Értékesítés és Sales']);
        Category::create(['name' => 'Tartalomgyártás és Copywriting']);
        Category::create(['name' => 'Grafikai tervezés és Videóvágás']);
        Category::create(['name' => 'Ügyfélszolgálat']);
        Category::create(['name' => 'Gyártás és Termelés']);
        Category::create(['name' => 'Szállítás és Logisztika']);
        Category::create(['name' => 'Építőipar és Ingatlan']);
        Category::create(['name' => 'Vendéglátás és Turizmus']);
        Category::create(['name' => 'Mezőgazdaság és Élelmiszeripar']);
        Category::create(['name' => 'Oktatás és Képzés']);
        Category::create(['name' => 'Egészségügy és Gyógyszeripar']);
        Category::create(['name' => 'Szépségápolás és Well-being']);
        Category::create(['name' => 'Környezetvédelem és Fenntarthatóság']);
    }
}
