<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Project;
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
        $projects = [
            [
                'title' => 'Island crossing',
                'subtitle' => "Sous-titre d'island crossing",
                'description' => "Description du magnifique projet d'island crossing",
                'color' => '#368E6A'
            ],
            [
                'title' => 'Malton',
                'subtitle' => 'Sous-titre de Malton',
                'description' => "Description du magnifique projet de Malton",
                'color' => '#E8B668'
            ],
        ];

        foreach ($projects as $project) {
            $project = Project::updateOrCreate($project);
            $project->modules()->sync(Module::all()->random(6), ['created_at' => Carbon::now(),'updated_at' => Carbon::now()]);
        }
    }
}
