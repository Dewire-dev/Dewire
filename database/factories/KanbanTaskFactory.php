<?php

namespace Database\Factories;

use App\Models\Kanban;
use App\Models\KanbanList;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class KanbanTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'description' => fake()->text(50),
            'date_start' => Carbon::now(),
            'date_end' => Carbon::now()->addDays(random_int(1, 7)),
            'scheduled_time' => fake()->numberBetween(60, 600),
        ];
    }
}
