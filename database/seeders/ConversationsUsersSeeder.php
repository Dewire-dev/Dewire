<?php

namespace Database\Seeders;

use App\Models\Conversations;
use App\Models\ConversationsUsers;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConversationsUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conversationsUsers = [
            [
                'user_id' => User::where('email', 'mathieu.neyret@ynov.com')->first()->id,
                'conversation_id' => Conversations::where('name', 'Conversation Malton Retour client')->first()->id,
            ],
            [
                'user_id' => User::where('email', 'anael.bonnafous@ynov.com')->first()->id,
                'conversation_id' => Conversations::where('name', 'Conversation Malton Retour client')->first()->id,
            ],
            [
                'user_id' => User::where('email', 'logan.lesaux@ynov.com')->first()->id,
                'conversation_id' => Conversations::where('name', 'Conversation Island crossing Retour client')->first()->id,
            ],
            [
                'user_id' => User::where('email', 'theonicolas19@outlook.com')->first()->id,
                'conversation_id' => Conversations::where('name', 'Conversation Island crossing Retour client')->first()->id,
            ]
        ];

        foreach ($conversationsUsers as $conversationUser) {
            ConversationsUsers::updateOrCreate($conversationUser);
        }
    }
}