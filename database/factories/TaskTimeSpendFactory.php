<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskTimeSpend;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskTimeSpendFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TaskTimeSpend::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'time' => $this->faker->numberBetween(15, 60),
            'description' => $this->faker->text(),
            'date' => $this->faker->dateTime()->setTime(17, 30),
        ];
    }

    public function assignToUser(User $user): static
    {
        return $this->state([
            'user_id' => $user->id,
        ]);
    }

    public function assignToTask(Task $task): static
    {
        return $this->state([
            'task_id' => $task->id,
        ]);
    }
}
