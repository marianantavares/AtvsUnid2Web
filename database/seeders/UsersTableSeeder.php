<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'bibliotecario@example.com'],
            [
                'name' => 'Bibliotecario User',
                'password' => Hash::make('password'),
                'role' => 'bibliotecario',
            ]
        );

        User::firstOrCreate(
            ['email' => 'cliente@example.com'],
            [
                'name' => 'Cliente User',
                'password' => Hash::make('password'),
                'role' => 'cliente',
            ]
        );
    }
}