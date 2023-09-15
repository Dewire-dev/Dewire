<?php

use App\Models\Project;
use App\Models\Chat;
use App\Models\ChatsUser;
use App\Models\Message;
use App\Models\MessageReadUser;
use App\Models\User;
use Illuminate\Support\Str;

test('user can add a conversation and link up with another user', function () {
    // Arrange
    [$user, $project] = initProject(['chats']);
    $user2 = User::factory()->create();
    $chat = Chat::factory()
        ->assignToProject($project)
        ->create()
    ;
    $chatsUser = ChatsUser::factory()
        ->assignToChat($chat)
        ->assignToUser($user)
        ->create()
    ;

    // Act
    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->post('/projects/' . $project->id . '/chats', [
        'chatSubject' => Str::random(20),
        'chatName' => Str::random(10),
        'chatUsers' => [
            $user->id,
            $user2->id,
        ]
    ]);

    // Assert
    $response->assertRedirect(route('chats.index', ['project' => $project]));
});
