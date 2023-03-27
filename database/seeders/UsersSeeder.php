<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'firstname' => 'Théo',
                'lastname' => 'NICOLAS',
                'email' => 'theonicolas19@outlook.com',
                'password' => 'password',
            ],
            [
                'firstname' => 'Mathieu',
                'lastname' => 'NEYRET',
                'email' => 'mathieuneyret@ynov.com',
                'password' => 'password',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }

    }
}
