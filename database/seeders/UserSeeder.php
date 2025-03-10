<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Raihan',
            'email' => 'admin@smk7.com',
            'password' => '123123123',
            'role_id' => 1
        ]);
        User::create([
            'name' => 'Andi Muh Raihan Alkawsar',
            'email' => '0077865020@smk7.com',
            'password' => '123123123',
            'role_id' => 3
        ]);
    }
}
