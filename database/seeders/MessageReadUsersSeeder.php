<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\MessageReadUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageReadUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = Message::all();

        foreach ($messages as $message) {
            $users = User::inRandomOrder()->take(rand(1,3))->get();
            foreach ($users as $user) {
                MessageReadUser::create([
                    'message_id' => $message->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
