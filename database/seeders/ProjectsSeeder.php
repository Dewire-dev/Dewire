<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $elgoneTeam = Team::where('name', 'ElGone\'s Team')->first();
        $maltdevTeam = Team::where('name', 'MALTdev')->first();
        $milokiaTeam = Team::where('name', 'Milokia\'s Team')->first();
        $cybermindTeam = Team::where('name', 'CyberMind\'s Team')->first();

        $projects = [
            [
                'title' => 'ElGone',
                'subtitle' => "Sous-titre de ElGone",
                'description' => "Description du magnifique projet ElGone",
                'color' => '#F4F4F4',
                'team_id' => $elgoneTeam->id,
            ],
            [
                'title' => 'Island crossing',
                'subtitle' => "Sous-titre d'island crossing",
                'description' => "Description du magnifique projet d'island crossing",
                'color' => '#368E6A',
                'team_id' => $maltdevTeam->id,
            ],
            [
                'title' => 'Malton',
                'subtitle' => 'Sous-titre de Malton',
                'description' => "Description du magnifique projet de Malton",
                'color' => '#E8B668',
                'team_id' => $maltdevTeam->id,
            ],
            [
                'title' => 'Milokia',
                'subtitle' => 'Sous-titre de Milokia',
                'description' => "Description du magnifique projet de Milokia",
                'color' => '#Af97DE',
                'team_id' => $milokiaTeam->id,
            ],
            [
                'title' => 'CyberMind',
                'subtitle' => 'Sous-titre de CyberMind',
                'description' => "Description du magnifique projet de CyberMind",
                'color' => '#E33636',
                'team_id' => $cybermindTeam->id,
            ],
        ];

        foreach ($projects as $project) {
            $project = Project::updateOrCreate($project);
            $modules = Module::where(['is_generic' => false])->get();
            $project->modules()->sync($modules->random($project['title'] === 'Test' ? count($modules) : 3), ['created_at' => Carbon::now(),'updated_at' => Carbon::now()]);
        }
    }
}
