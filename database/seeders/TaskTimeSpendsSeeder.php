<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskTimeSpend;
use App\Models\User;
use Illuminate\Database\Seeder;
use function Sodium\add;

class TaskTimeSpendsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $task1 = Task::where(['label' => 'Intégration page inscription'])->first();

        $user1 = User::where(['email' => 'logan.lesaux@ynov.com'])->first();
        $user2 = User::where(['email' => 'theonicolas19@outlook.com'])->first();

        $tomorrowTask1StartAt = new \DateTimeImmutable($task1->start_at);

        $taskTimeSpends = [
            [
                'description' => "Debrief sujet avec Logan.",
                'time' => 15,
                'user_id' => $user2->id,
                'task_id' => $task1->id,
                'date' => $task1->start_at,
            ],
            [
                'description' => "Debrief avec Théo",
                'time' => 15,
                'user_id' => $user1->id,
                'task_id' => $task1->id,
                'date' => $task1->start_at,
            ],
            [
                'description' => "Inté",
                'time' => 80,
                'user_id' => $user1->id,
                'task_id' => $task1->id,
                'date' => $tomorrowTask1StartAt->add(new \DateInterval('P1D')),
            ],
        ];

        foreach ($taskTimeSpends as $taskTimeSpend) {
            TaskTimeSpend::updateOrCreate($taskTimeSpend);
        }
    }
}
