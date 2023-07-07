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
        $maltdevTeam = Team::where('name', 'MALTdev')->first();
        $cybermindTeam = Team::where('name', 'CyberMind\'s Team')->first();

        $projects = [
            [
                'title' => 'Test',
                'subtitle' => "Sous-titre de Test",
                'description' => "Description du magnifique projet Test",
                'color' => '#1A80D5',
                'team_id' => $maltdevTeam->id,
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
                'title' => 'CyberMind',
                'subtitle' => 'Sous-titre de CyberMind',
                'description' => "Description du magnifique projet de CyberMind",
                'color' => '#E33636',
                'team_id' => $cybermindTeam->id,
            ],
        ];

        foreach ($projects as $project) {
            $project = Project::updateOrCreate($project);
            $project->modules()->sync(Module::all()->random(2), ['created_at' => Carbon::now(),'updated_at' => Carbon::now()]);
        }
    }
}
