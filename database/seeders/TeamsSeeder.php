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
              'user_id' => User::where('name', 'MathieuN')->first()->id,
              'name' => 'ElGone\'s Team',
              'personal_team' => false,
          ],
          [
              'user_id' => User::where('name', 'AnaelB')->first()->id,
              'name' => 'MALTdev',
              'personal_team' => false,
          ],
          [
              'user_id' => User::where('name', 'LoganLS')->first()->id,
              'name' => 'Milokia\'s Team',
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

            $team->users()->detach();

            $admins = User::where('id', '=', $team['user_id'])->get();
            $team->users()->attach($admins, ['role'=> 'admin']);

            $editors = User::where('id', '<>', $team['user_id'])->get();
            $team->users()->attach($editors, ['role'=> 'editor']);
        }


        foreach (User::all() as $user) {
            $user->switchTeam($user->allTeams()->where('name', 'MALTdev')->first());
        }
    }
}
