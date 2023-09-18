<?php

namespace Database\Factories;

use App\Models\Kanban;
use App\Models\KanbanList;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class KanbanListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'color' => fake()->hexColor,
            'position' => KanbanList::all()->last() ? KanbanList::all()->last()->position + 1 : 1,
        ];
    }
}
