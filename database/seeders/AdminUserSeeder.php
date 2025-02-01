<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Borrowing;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;

class AdminUserSeeder extends Seeder{

    public function run()
    {
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }
}    