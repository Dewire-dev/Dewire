<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\TaskState;
use App\Enum\TaskType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('project_id')->nullable()->index();
            $table->foreignUlid('user_creator_id')->index();
            $table->string('label');
            $table->text('description')->nullable();
            $table->integer('scheduled_time')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->enum('state', array_column(TaskState::cases(), 'value'));
            $table->enum('type', array_column(TaskType::cases(), 'value'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
