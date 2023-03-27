<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
          [
              'user_id' => User::first()->id,
              'name' => 'CookiesShop',
              'personal_team' => false,
          ]
        ];

        foreach ($teams as $team) {
            $team = Team::updateOrCreate(['name' => 'CookiesShop'], $team);
        }

        $team->users()->detach();
        $team->users()->attach(User::all(), ['role'=> 'editor']);

        foreach (User::all() as $user) {
            $user->switchTeam($team);
        }
    }
}
