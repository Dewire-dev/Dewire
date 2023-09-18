<?php

namespace Database\Seeders;

use App\Models\Kanban;
use App\Models\KanbanList;
use Illuminate\Database\Seeder;

class KanbanListSeeder extends Seeder
{
    const LIST_NAMES = [
        'A faire',
        'En cours',
        'Terminer'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::LIST_NAMES as $LIST_NAME) {
            foreach (Kanban::all() as $kanban) {
                KanbanList::factory()->create([
                    'kanban_id' => $kanban->id,
                    'name' => $LIST_NAME
                ]);
            }
        }

    }
}
