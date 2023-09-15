<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ChatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chat::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => '',
            'name' => '',
        ];
    }

    public function assignToProject(Project $project): static
    {
        return $this->state([
            'project_id' => $project->id,
        ]);
    }

    public function assignToOneUser(User $user): static
    {
        return $this->afterCreating(function (Chat $chat) use ($user) {
            $chat->users()->attach($user);
        });
    }
}
