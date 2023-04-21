<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = [
            [
                'sender_id' => User::where('email', 'mathieu.neyret@ynov.com')->first()->id,
                'chat_id' => Chat::where('name', 'Chat Malton Retour client')->first()->id,
                'content' => 'Salut Anaël, tu peux faire un retour client stp ?',
            ],
            [
                'sender_id' => User::where('email', 'anael.bonnafous@ynov.com')->first()->id,
                'chat_id' => Chat::where('name', 'Chat Malton Retour client')->first()->id,
                'content' => 'Salut Mathieu, pas de soucis',
            ],
            [
                'sender_id' => User::where('email', 'mathieu.neyret@ynov.com')->first()->id,
                'chat_id' => Chat::where('name', 'Chat Malton Retour client')->first()->id,
                'content' => 'Ok merci',
            ],
            [
                'sender_id' => User::where('email', 'logan.lesaux@ynov.com')->first()->id,
                'chat_id' => Chat::where('name', 'Chat Island crossing Retour client')->first()->id,
                'content' => "Yo Théo, j'ai un client qui me harcèle pour qu'on lui fasse un devis, occupe toi en stp",
            ],
            [
                'sender_id' => User::where('email', 'theonicolas19@outlook.com')->first()->id,
                'chat_id' => Chat::where('name', 'Chat Island crossing Retour client')->first()->id,
                'content' => "Trop la flemme, tu n'as qu'à le faire toi",
            ],
            [
                'sender_id' => User::where('email', 'logan.lesaux@ynov.com')->first()->id,
                'chat_id' => Chat::where('name', 'Chat Island crossing Retour client')->first()->id,
                'content' => 'Super merci de ton aide...',
            ],
            [
                'sender_id' => User::where('email', 'mathieu.neyret@ynov.com')->first()->id,
                'chat_id' => Chat::where('name', 'Chat Malton privé')->first()->id,
                'content' => 'Yo la team, premier message pour Malton en privé',
            ],
            [
                'sender_id' => User::where('email', 'anael.bonnafous@ynov.com')->first()->id,
                'chat_id' => Chat::where('name', 'Chat Malton privé')->first()->id,
                'content' => 'Coucou',
            ],
            [
                'sender_id' => User::where('email', 'mathieu.neyret@ynov.com')->first()->id,
                'chat_id' => Chat::where('name', 'Chat Island crossing privé')->first()->id,
                'content' => 'Yo la team, premier message pour Island crossing en privé',
            ],
            [
                'sender_id' => User::where('email', 'anael.bonnafous@ynov.com')->first()->id,
                'chat_id' => Chat::where('name', 'Chat Island crossing privé')->first()->id,
                'content' => 'Coucou',
            ]
        ];

        foreach ($messages as $message) {
            Message::updateOrCreate($message);
        }
    }
}
