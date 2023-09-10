<?php

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskTimeSpend;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

test('user can add two times with a commentary for each time entered', function () {
    // Arrange
    $user = User::factory()->create();
    $project = Project::factory()->create();
    $task = Task::factory()
        ->assignToOneUser($user)
        ->assignToProject($project)
        ->create()
    ;
    $numberTaskTimeSpendsBefore = $task->taskTimeSpends()->count();

    // Act
    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->put('/time/' . $task->id . '/update-task-time-spends', [
        'taskTimeSpends' => [
            [
                'time' => 30,
                'description' => 'Intégration CTA',
                'date' => (new \DateTime('now'))->format('Y-m-d'),
            ],
            [
                'time' => 45,
                'description' => 'Brief avec le client pour l\'évol sur la navbar',
                'date' => (new \DateTime('now'))->format('Y-m-d'),
            ],
        ],
    ]);

    $response->assertStatus(200);
    $this->assertEquals(0, $numberTaskTimeSpendsBefore);
    $this->assertEquals(2, $task->taskTimeSpends()->count());
});

test('user can delete one time spended', function () {
    // Arrange
    $user = User::factory()->create();
    $project = Project::factory()->create();
    $task = Task::factory()
        ->assignToOneUser($user)
        ->assignToProject($project)
        ->create()
    ;
    $taskTimeSpend = TaskTimeSpend::factory()
        ->assignToUser($user)
        ->assignToTask($task)
        ->create()
    ;

    // Act
    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->delete('/time/' . $task->id . '/delete-task-time-spend/' . $taskTimeSpend->id);

    // Assert
    $response->assertStatus(200);
});

test('user can not delete one time spended for another person', function () {
    // Arrange
    $user = User::factory()->create();
    $user2 = User::factory()->create();
    $project = Project::factory()->create();
    $task = Task::factory()
        ->assignToOneUser($user)
        ->assignToProject($project)
        ->create()
    ;
    $taskTimeSpends = TaskTimeSpend::factory()
        ->count(3)
        ->assignToUser($user)
        ->assignToTask($task)
        ->create()
    ;
    $taskTimeSpendTryToDelete = $taskTimeSpends[0];

    // Act
    $this->post('/login', [
        'email' => $user2->email,
        'password' => 'password',
    ]);

    $response = $this->delete('/time/' . $task->id . '/delete-task-time-spend/' . $taskTimeSpendTryToDelete->id);

    // Assert
    $response->assertStatus(403);
});
