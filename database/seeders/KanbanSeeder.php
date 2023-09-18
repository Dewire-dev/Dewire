<?php

namespace Database\Seeders;

use App\Models\Kanban;
use App\Models\Project;
use Illuminate\Database\Seeder;

class KanbanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Project::all() as $project) {
            Kanban::factory()->count(3)->create([
                'project_id' => $project->id
            ]);
        }

    }
}
