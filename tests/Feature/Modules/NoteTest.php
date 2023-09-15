<?php

use App\Models\Module;
use App\Models\Note;
use App\Models\Project;
use App\Models\User;
use Database\Seeders\ModuleSeeder;
use Illuminate\Support\Facades\Artisan;

use function Pest\Laravel\{actingAs, seed};
use function PHPUnit\Framework\{assertEquals, assertInstanceOf, assertSame, assertTrue};

test('notes can be created in project', function () {
    // Arrange
    [$user, $project] = initProject(['notes']);

    $noteName = 'Ma nouvelle note';

    // Act
    $responseStore = actingAs($user)->post(
        route('projects.notes.store',
            ['project' => $project]
        ), ['name' => $noteName]);

    $responseIndex = actingAs($user)->get(
        route('projects.notes.index',
            ['project' => $project]
        ));

    $note = Note::first();

    $responseShow = actingAs($user)->get(
        route('projects.notes.show',
            ['project' => $project, 'note' => $note]
        ));

    // Assert
    $responseStore->assertOk();
    $responseIndex->assertOk()->assertSee($noteName);
    $responseShow->assertOk()->assertSee($noteName);

    assertInstanceOf(Project::class, $note->project);
    assertSame($project->id, $note->project->id);
    assertEquals(1, $project->notes->count());
    assertTrue($project->notes->contains($note));
});

test('notes can be deleted from project', function () {
    // Arrange
    [$user, $project] = initProject(['notes']);

    $note = Note::factory()->make(['user_id' => $user->id]);
    $project->notes()->save($note);

    // Act
    $responseIndex = actingAs($user)->get(
        route('projects.notes.index',
            ['project' => $project]
        ));

    $responseDestroy = actingAs($user)->delete(
        route('projects.notes.destroy',
            ['project' => $project, 'note' => $note]
        ));

    $responseShow = actingAs($user)->get(
        route('projects.notes.show',
            ['project' => $project, 'note' => $note]
        ));

    // Assert
    $responseIndex->assertOk();
    $responseDestroy->assertOk();
    $responseShow->assertNotFound();

    assertEquals(0, $project->notes->count());
    assertTrue(! $project->notes->contains($note));
});
