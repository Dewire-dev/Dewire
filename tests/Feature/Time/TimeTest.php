<?php

use App\Models\Task;
use App\Models\User;

test('user can add two times with a commentary for each time entered', function () {
    // Arrange
    $user = User::factory()->create();
    $task = Task::factory()
        ->assignToOneUser($user)
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
            ],
            [
                'time' => 45,
                'description' => 'Brief avec le client pour l\'évol sur la navbar',
            ],
        ],
    ]);

    $response->assertStatus(200);
    $this->assertEquals(0, $numberTaskTimeSpendsBefore);
    $this->assertEquals(2, $task->taskTimeSpends()->count());
});
