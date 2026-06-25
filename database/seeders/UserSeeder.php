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
            'password' => bcrypt('12345678'),
            'role' => 'Admin',
        ],
        [
            'name' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'User',
        ],
        [
            'name' => 'Jane Smith',
            'email' => 'jane.smith@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'User',
        ],
        [
            'name' => 'Michael Johnson',
            'email' => 'michael.johnson@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'User',
        ],
        [
            'name' => 'Emily Davis',
            'email' => 'emily.davis@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'User',
        ],
        [
            'name' => 'William Brown',
            'email' => 'william.brown@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'User',
        ],
        [
            'name' => 'Olivia Wilson',
            'email' => 'olivia.wilson@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'User',
        ],
        [
            'name' => 'James Taylor',
            'email' => 'james.taylor@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'User',
        ],
        [
            'name' => 'Sophia Anderson',
            'email' => 'sophia.anderson@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'User',
        ],
        [
            'name' => 'Daniel Thomas',
            'email' => 'daniel.thomas@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'User',
        ],
        [
            'name' => 'Emma Martinez',
            'email' => 'emma.martinez@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'User',
        ],
    ];

    foreach ($users as $user) {
        User::create($user);
    }
}
}
