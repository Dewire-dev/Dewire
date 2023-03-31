<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\ChatsUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatsUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chatsUser = [
            [
                'user_id' => User::where('email', 'mathieu.neyret@ynov.com')->first()->id,
                'chat_id' => Chat::where('name', 'Chat Malton Retour client')->first()->id,
            ],
            [
                'user_id' => User::where('email', 'anael.bonnafous@ynov.com')->first()->id,
                'chat_id' => Chat::where('name', 'Chat Malton Retour client')->first()->id,
            ],
            [
                'user_id' => User::where('email', 'logan.lesaux@ynov.com')->first()->id,
                'chat_id' => Chat::where('name', 'Chat Island crossing Retour client')->first()->id,
            ],
            [
                'user_id' => User::where('email', 'theonicolas19@outlook.com')->first()->id,
                'chat_id' => Chat::where('name', 'Chat Island crossing Retour client')->first()->id,
            ]
        ];

        foreach ($chatsUser as $chatUser) {
            ChatsUser::updateOrCreate($chatUser);
        }
    }
}
