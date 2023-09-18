<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(UsersSeeder::class);
        $this->call(TeamsSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(ProjectsSeeder::class);
        $this->call(ChatsSeeder::class);
        $this->call(ChatsUsersSeeder::class);
        $this->call(MessagesSeeder::class);
        $this->call(TasksSeeder::class);
        $this->call(TaskTimeSpendsSeeder::class);
    }
}
