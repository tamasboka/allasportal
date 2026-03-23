<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'firstname' => 'Tamás',
            'lastname' => 'Bóka',
            'email' => 'tamasboka@jobnest.hu',
            'password' => 'jelszo12345',
            'gender' => 'male',
            'phone' => '062012312312',
        ]);
        User::create([
            'firstname' => 'Bence',
            'lastname' => 'Beretzky',
            'email' => 'beretzkybence@jobnest.hu',
            'password' => 'jelszo121212',
            'gender' => 'male',
            'phone' => '0630676767',
        ]);
    }
}
