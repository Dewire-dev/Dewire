<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'MathieuN',
                'firstname' => 'Mathieu',
                'lastname' => 'NEYRET',
                'email' => 'mathieu.neyret@ynov.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'AnaelB',
                'firstname' => 'Anaël',
                'lastname' => 'BONNAFOUS',
                'email' => 'anael.bonnafous@ynov.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'LoganLS',
                'firstname' => 'Logan',
                'lastname' => 'LESAUX',
                'email' => 'logan.lesaux@ynov.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'TheoN',
                'firstname' => 'Théo',
                'lastname' => 'NICOLAS',
                'email' => 'theonicolas19@outlook.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }

    }
}
