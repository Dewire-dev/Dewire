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
              'user_id' => User::where('name', 'AnaelB')->first()->id,
              'name' => 'MALTdev',
              'personal_team' => false,
          ],
          [
              'user_id' => User::where('name', 'TheoN')->first()->id,
              'name' => 'CyberMind\'s Team',
              'personal_team' => false,
          ],
        ];

        foreach ($teams as $team) {
            $team = Team::updateOrCreate(['name' => $team['name']], $team);
        }

        $team->users()->detach();
        $team->users()->attach(User::all(), ['role'=> 'editor']);

        foreach (User::all() as $user) {
            $user->switchTeam($team);
        }
    }
}
