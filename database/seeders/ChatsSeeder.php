<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chats = [
            [
                'subject' => 'La conversation Malton destiné aux retours client',
                'name' => 'Chat Malton Retour client',
                'project_id' => Project::where('title', 'Malton')->first()->id,
            ],
            [
                'subject' => 'La conversation Island crossing destiné aux retours client',
                'name' => 'Chat Island crossing Retour client',
                'project_id' => Project::where('title', 'Island crossing')->first()->id,
            ],
            [
                'subject' => 'La conversation Malton privé entre nous',
                'name' => 'Chat Malton privé',
                'project_id' => Project::where('title', 'Malton')->first()->id,
            ],
            [
                'subject' => 'La conversation Island crossing privé entre nous',
                'name' => 'Chat Island crossing privé',
                'project_id' => Project::where('title', 'Island crossing')->first()->id,
            ]
        ];

        foreach ($chats as $chat) {
            Chat::updateOrCreate($chat);
        }
    }
}
