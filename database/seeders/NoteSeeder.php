<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $noteNumbers = 10;

        $projects = Project::whereHas('modules', function ($query) {
            $query->where('slug', 'notes');
        });

        for ($i = 0; $i < $noteNumbers; $i++) {
            $project = $projects->inRandomOrder()->first();
            $user = $project->team->users()->inRandomOrder()->first();

            Note::factory()->create([
                'name' => 'Note',
                'project_id' => $project->id,
                'user_id' => $user->id,
            ]);
        }
    }
}
