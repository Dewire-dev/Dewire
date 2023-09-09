<?php

namespace Database\Factories;

use App\Enum\TaskState;
use App\Enum\TaskType;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'label' => Str::random(10),
            'description' => $this->faker->text(),
            'scheduled_time' => $this->faker->numberBetween(30, 90),
            'start_at' => $this->faker->dateTime()->setTime(9, 0),
            'end_at' => $this->faker->dateTime()->add(new \DateInterval('PT7H')),
            'state' => TaskState::TO_DO,
            'type' => TaskType::CLIENT_PROJECT,
            'user_creator_id' => User::factory(),
            'project_id' => Project::factory(),
        ];
    }

    public function assignToOneUser(User $user): static
    {
        return $this->afterCreating(function (Task $task) use ($user) {
            return $task->users()->attach($user);
        });
    }
}
