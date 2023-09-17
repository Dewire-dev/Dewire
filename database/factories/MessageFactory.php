<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => '',
        ];
    }

    public function assignToChat(Chat $chat): static
    {
        return $this->state([
            'chat_id' => $chat->id,
        ]);
    }

    public function assignToUser(User $user): static
    {
        return $this->state([
            'sender_id' => $user->id,
        ]);
    }
}
