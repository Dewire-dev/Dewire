<?php

use App\Models\Chat;
use App\Models\ChatsUser;
use App\Models\Message;
use App\Models\MessageReadUser;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Str;

use function PHPUnit\Framework\{assertEquals, assertInstanceOf, assertSame, assertTrue};

test('user can add a conversation and join two other users in the conversation', function () {
    // Arrange
    [$user, $project] = initProject(['chats']);
    $user2 = User::factory()->create();
    $user3 = User::factory()->create();

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
            $user3->id,
        ]
    ]);

    $chat = Chat::first();

    // Assert
    $response->assertStatus(200);
    assertInstanceOf(Project::class, $chat->project);
    assertSame($project->id, $chat->project->id);
    assertEquals(1, $project->chats->count());
    assertTrue($project->chats->contains($chat));

});

test('user can send a message and mark not read for two another user in chat', function() {
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
    $chatsUser2 = ChatsUser::factory()
        ->assignToChat($chat)
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

    $message = Message::first();

    // Assert
    $response->assertStatus(200);
    $this->assertDatabaseHas('messages', [
        'sender_id' => $user->id,
        'chat_id' => $chat->id
    ]);
    $this->assertDatabaseHas('message_read_users', [
        'user_id' => $user2->id,
        'message_id' => $message->id
    ]);
});

test('user can exit a chat', function () {
    // Arrange
    [$user, $project] = initProject(['chats']);
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

    $response = $this->delete('/projects/' . $project->id . '/chats/' . $chat->id . '/delete_user', [
        'chatId' => $chat->id,
        'userId' => $user->id,
    ]);

    // Assert
    $response->assertRedirect(route('chats.index', ['project' => $project]));
    $this->assertDatabaseMissing('chats_users', [
        'chat_id' => $chat->id,
        'user_id' => $user->id,
    ]);
});
