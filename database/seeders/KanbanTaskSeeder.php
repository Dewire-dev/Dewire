<?php

namespace Database\Seeders;

use App\Enum\TaskState;
use App\Models\KanbanList;
use App\Models\KanbanTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class KanbanTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (KanbanList::all() as $kanban_list) {
            $dateStart = Carbon::now()->addDays(random_int(1, 3));
            $tasks = KanbanTask::factory()->count(5)->create([
                'kanban_list_id' => $kanban_list->id,
                'date_start' => $dateStart,
                'date_end' => $dateStart->addDays(random_int(1, 2)),
            ]);
//            foreach ($tasks as $taskKanban) {
//                $taskKanban->members = User::inRandomOrder()->limit(3)->pluck('id');
//                $task = Task::create([
//                    'project_id'      => $taskKanban->list->kanban->project->id,
//                    'user_creator_id' => User::inRandomOrder()->first()->id,
//                    'label'           => $taskKanban->name,
//                    'description'     => $taskKanban->description,
//                    'state'           => TaskState::TO_DO,
//                    'kanban_task_id'  => $taskKanban->id,
//                    'start_at'        => $taskKanban->date_start,
//                    'end_at'          => $taskKanban->date_end,
//                    'scheduled_time'  => $taskKanban->scheduled_time,
//                ]);
//
//                $task->users()->sync($taskKanban->members);
//            }
        }

    }
}
