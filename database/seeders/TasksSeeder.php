<?php

namespace Database\Seeders;

use App\Enum\TaskState;
use App\Enum\TaskType;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $project1 = Project::where(['title' => 'Island crossing'])->first();
        $project2 = Project::where(['title' => 'Malton'])->first();

        $user1 = User::where(['email' => 'logan.lesaux@ynov.com'])->first();
        $user2 = User::where(['email' => 'theonicolas19@outlook.com'])->first();
        $user3 = User::where(['email' => 'anael.bonnafous@ynov.com'])->first();
        $user4 = User::where(['email' => 'mathieu.neyret@ynov.com'])->first();

        $now = new \DateTimeImmutable();

        $tasks = [
            [
                'label' => 'Intégration page inscription',
                'description' => "Voir le lien figma : https://www.figma.com/file/StmXWxkTj1IkIHCGwCKNh9/CyberMind?node-id=0-1\n\nSi besoin de plus d'informations : contacter le webdesigner de l'équipe : Côme",
                'project_id' => $project1->id,
                'scheduled_time' => 180,
                'start_at' => $now,
                'end_at' => $now->add(new \DateInterval('P1D')),
                'state' => TaskState::IN_PROGRESS,
                'type' => TaskType::CLIENT_PROJECT,
                'user_creator_id' => $user2->id,
            ],
            [
                'label' => 'Formulaire inscription',
                'description' => "Champs nécessaires:\n- Email\n- Mot de passe\n- Confirmation mot de passe",
                'project_id' => $project1->id,
                'scheduled_time' => 300,
                'start_at' => $now->add(new \DateInterval('P2D')),
                'end_at' => $now->add(new \DateInterval('P5D')),
                'state' => TaskState::IN_MERGE_REQUEST,
                'type' => TaskType::CLIENT_PROJECT,
                'user_creator_id' => $user2->id,
            ],
            [
                'label' => 'Réunion lancement projet',
                'description' => null,
                'project_id' => $project2->id,
                'scheduled_time' => 300,
                'start_at' => $now->add(new \DateInterval('P10D')),
                'end_at' =>$now->add(new \DateInterval('P15D')),
                'state' => TaskState::TO_DO,
                'type' => TaskType::CLIENT_PROJECT,
                'user_creator_id' => $user2->id,
            ],
            [
                'label' => '[Interne] Réunion développeur front-end',
                'description' => null,
                'project_id' => null,
                'scheduled_time' => 300,
                'start_at' => $now->add(new \DateInterval('P1D')),
                'end_at' => $now->add(new \DateInterval('P1D')),
                'state' => TaskState::TO_DO,
                'type' => TaskType::INTERNAL,
                'user_creator_id' => $user2->id,
            ],
            [
                'label' => '[Interne] Divers',
                'description' => null,
                'project_id' => null,
                'start_at' => null,
                'end_at' => null,
                'state' => TaskState::IN_PROGRESS,
                'type' => TaskType::INTERNAL,
                'user_creator_id' => $user2->id,
            ],
        ];

        $tasksUsers = [
            [$user1->id, $user2->id],
            [$user1->id, $user2->id],
            [$user1->id, $user2->id, $user3->id, $user4->id],
            [$user1->id, $user3->id, $user4->id],
            null,
        ];

        foreach ($tasks as $key => $task) {
            $t = Task::updateOrCreate($task);

            if (!empty($tasksUsers[$key])) {
                $t->users()->sync($tasksUsers[$key]);
            }
        }
    }
}
