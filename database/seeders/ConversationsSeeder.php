<?php

namespace Database\Seeders;

use App\Models\Conversations;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConversationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conversations = [
            [
                'subject' => 'La conversation Malton destiné aux retours client',
                'name' => 'Conversation Malton Retour client',
                'project_id' => Project::where('title', 'Malton')->first()->id,
            ],
            [
                'subject' => 'La conversation Island crossing destiné aux retours client',
                'name' => 'Conversation Island crossing Retour client',
                'project_id' => Project::where('title', 'Island crossing')->first()->id,
            ]
        ];

        foreach ($conversations as $conversation) {
            Conversations::updateOrCreate($conversation);
        }
    }
}
