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
                'title' => 'Projet 1',
                'subtitle' => 'Sous-projet 1',
                'description' => 'Description du premier projet',
            ],
            [
                'title' => 'Projet 2',
                'subtitle' => 'Sous-projet 2',
                'description' => 'Description du deuxième projet',
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate($project);
        }
    }
}
