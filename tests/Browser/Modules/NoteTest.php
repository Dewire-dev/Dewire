<?php

namespace Tests\Browser\Modules;

use App\Models\Module;
use App\Models\Note;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class NoteTest extends DuskTestCase
{
    use DatabaseTruncation;

    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
     protected function setUp(): void
      {
          parent::setUp();
          $this->artisan('db:seed', ['--class' => 'ModuleSeeder']);
      }

    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $team = Team::factory()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $team->users()->syncWithPivotValues([$user1->id, $user2->id], ['role' => 'editor']);
        $user1->switchTeam($team);
        $user2->switchTeam($team);

        $project = Project::factory()->create(['team_id' => $team->id]);
        $project->modules()->attach(Module::find('notes'));

        $note = Note::factory()->create(['project_id' => $project->id, 'content' => '']);

        $this->browse(function (Browser $first, Browser $second) use ($user1, $user2, $project, $note) {
            $first->loginAs($user1)
                    ->visitRoute('projects.notes.show', ['project' => $project, 'note' => $note])
                    ->assertSee($note->name)
                    ->type('.ProseMirror', 'My today note');

            $second->loginAs($user2)
                    ->visitRoute('projects.notes.show', ['project' => $project, 'note' => $note])
                    ->assertSee($note->name);
        });
    }
}
