<?php

use App\Models\Chat;
use App\Models\ChatsUser;
use App\Models\Message;
use App\Models\MessageReadUser;
use App\Models\User;
use Illuminate\Support\Str;

test('user can add a conversation and link up with 2 another user', function () {
    // Arrange
    [$user, $project] = initProject(['chats']);
    $user2 = User::factory()->create();
    $user3 = User::factory()->create();
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
            $user2->id,
            $user3->id,
        ]
    ]);

    // Assert
    $response->assertRedirect(route('chats.index', ['project' => $project]));
});

test('user can send a message and mark not read for another user', function() {
    // Arrange
    [$user, $project] = initProject(['chats']);
    $user2 = User::factory()->create();
    $chat = Chat::factory()
        ->assignToProject($project)
        ->create()
    ;
    $message = Message::factory()
        ->assignToChat($chat)
        ->assignToUser($user)
        ->create()
    ;
    $messageReadUser = MessageReadUser::factory()
        ->assignToMessage($message)
        ->assignToUser($user2)
        ->create()
    ;

    // Act
    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);


    $response = $this->post('/projects/' . $project->id . '/chats/' . $chat->id . '/create_message', [
        'content' => Str::random(100),
    ]);

    // Assert
    $response->assertRedirect(route('chats.show', ['project' => $project, 'chat' => $chat]));
});

test('user can adding 2 another user in chat', function() {
    // Arrange
    [$user, $project] = initProject(['chats']);
    $user2 = User::factory()->create();
    $user3 = User::factory()->create();
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

    $response = $this->post('/projects/' . $project->id . '/chats/' . $chat->id . '/add_user', [
        'users' => [
            $user2->id,
            $user3->id,
        ]
    ]);

    // Assert
    $response->assertRedirect(route('chats.show', ['project' => $project, 'chat' => $chat]));
});

test('user can exit a chat', function () {
    // Arrange
    [$user, $project] = initProject(['chats']);
    $chat = Chat::factory()
        ->assignToProject($project)
        ->create()
    ;
    $chatsUser = ChatsUser::factory()
        ->count(3)
        ->assignToChat($chat)
        ->assignToUser($user)
        ->create()
    ;
    $chatsUserTryToDelete = $chatsUser[0];

    // Act
    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response = $this->delete('/projects/' . $project->id . '/chats/' . $chatsUserTryToDelete->id . '/delete_user', [
        'chatId' => $chatsUserTryToDelete->id
    ]);

    // Assert
    $response->assertRedirect(route('chats.index', ['project' => $project]));
});
