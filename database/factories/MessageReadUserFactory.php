<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\MessageReadUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageReadUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MessageReadUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }

    public function assignToMessage(Message $message): static
    {
        return $this->state([
            'message_id' => $message->id,
        ]);
    }

    public function assignToUser(User $user): static
    {
        return $this->state([
            'user_id' => $user->id,
        ]);
    }
}
