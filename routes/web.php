<?php

use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::apiResource('projects', \App\Http\Controllers\ProjectController::class);
    Route::post('/projects/{project}/attach/{module}', [\App\Http\Controllers\ProjectController::class, 'attachModule'])->name('modules.attach');
    Route::post('/projects/{project}/detach/{module}', [\App\Http\Controllers\ProjectController::class, 'detachModule'])->name('modules.detach');
    Route::apiResource('projects.chats', \App\Http\Controllers\ChatController::class)->except(['update', 'destroy'])->names('chats');
    Route::apiResource('projects.notes', \App\Http\Controllers\NoteController::class);
    Route::patch('/projects/{project}/notes/{note}/save', [\App\Http\Controllers\NoteController::class, 'save'])->name('notes.save');

    Route::apiResource('tasks', \App\Http\Controllers\TaskController::class);

    Route::prefix('times')->controller(\App\Http\Controllers\TimeController::class)->group(function () {
        Route::get('/', [\App\Http\Controllers\TimeController::class, 'index'])->name('times');
        Route::get('/get-previous-week', [\App\Http\Controllers\TimeController::class, 'getPreviousWeek'])->name('time.getPreviousWeek');
        Route::get('/get-next-week', [\App\Http\Controllers\TimeController::class, 'getNextWeek'])->name('time.getNextWeek');
        Route::get('/get-tasks-by-user', [\App\Http\Controllers\TimeController::class, 'getTasksByUser'])->name('time.getTasksByUser');

        Route::get('/task-time-spends/{task}/{date}/{user}', [\App\Http\Controllers\TaskController::class, 'taskTimeSpends'])->name('tasks.taskTimeSpends');
        Route::post('/{task}/add-comment', [\App\Http\Controllers\TaskController::class, 'addComment'])->name('tasks.addComment');
        Route::delete('/{task}/delete-comment/{taskComment}', [\App\Http\Controllers\TaskController::class, 'deleteComment'])->name('tasks.deleteComment');
        Route::put('/{task}/update-task-time-spends', [\App\Http\Controllers\TaskController::class, 'updateTaskTimeSpends'])->name('tasks.updateTaskTimeSpends');
        Route::delete('/{task}/delete-task-time-spend/{taskTimeSpend}', [\App\Http\Controllers\TaskController::class, 'deleteTaskTimeSpend'])->name('tasks.deleteTaskTimeSpends');
    });

    Route::post('/projects/{project}/chats/{chat}/read_messages', [\App\Http\Controllers\ChatController::class, 'markReadMessages'])->name('messages.read');
    Route::post('/projects/{project}/chats/{chat}/create_message', [\App\Http\Controllers\ChatController::class, 'createMessage'])->name('messages.store');
    Route::post('/projects/{project}/chats/{chat}/add_user', [\App\Http\Controllers\ChatController::class, 'addUser'])->name('messages.addUser');
    Route::delete('/projects/{project}/chats/{chat}/delete_user', [\App\Http\Controllers\ChatController::class, 'deleteUser'])->name('messages.deleteUser');
    Route::apiResource('projects.chats', \App\Http\Controllers\ChatController::class)
        ->except(['update', 'destroy'])
        ->names('chats');
    Route::apiResource('time', \App\Http\Controllers\TimeController::class);


    //Module Kanban
    Route::apiResource('projects.kanbans', \App\Http\Controllers\KanbanController::class)->except(['update'])->names('kanbans');
    Route::apiResource('projects.kanbans.kanban-lists', \App\Http\Controllers\KanbanListController::class)->except(['show'])->names('kanban_lists');
    Route::apiResource('projects.kanbans.kanban-tasks', \App\Http\Controllers\KanbanTaskController::class)->except(['show'])->names('kanban_tasks');

    Route::controller(\App\Http\Controllers\KanbanListController::class)->group(function () {
        Route::post('projects/{project}/{kanban_list}/kanban-lists-update-name', 'updateNameKanbanList')->name('kanban-lists-update-name');
        Route::post('projects/{project}/{kanban}/kanban-lists-update-position', 'updatePositionKanbanList')->name('kanban-lists-update-position');
    });

    Route::controller(\App\Http\Controllers\KanbanTaskController::class)->group(function () {
        Route::post('projects/{project}/{kanban_task}/kanban-tasks-update-position', 'updateTaskPosition')->name('kanban-tasks-update-position');
        Route::get('projects/{project}/{kanban_task}/kanban-tasks-get-members', 'getMembersTask')->name('kanban-tasks-get-members');
    });
});

Route::get('/connect/{name}', function (Request $request, string $name) {
    if (config('app.env') !== 'local') return redirect()->back();

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    Auth::login(User::where('name', $name)->first());

    return to_route('dashboard');
})->name('connect');
