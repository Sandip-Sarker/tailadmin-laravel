<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => '12345678',
                'role' => 'Admin'
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => '12345678',
                'role' => 'User'
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
