<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            ],
            [
                'title' => 'Malton',
                'subtitle' => 'Sous-titre de Malton',
                'description' => "Description du magnifique projet de Malton",
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate($project);
        }
    }
}
