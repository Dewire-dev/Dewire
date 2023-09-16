<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\ChatsUser;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatsUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ChatsUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
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
            'user_id' => $user->id,
        ]);
    }
}
