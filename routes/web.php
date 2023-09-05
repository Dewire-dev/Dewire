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
    Route::patch('/notes/{note}/save', [\App\Http\Controllers\NoteController::class, 'save'])->name('notes.save');

    Route::post('/read_messages', [\App\Http\Controllers\ChatController::class, 'markReadMessages']);
    Route::post('/create_chat', [\App\Http\Controllers\ChatController::class, 'createChats'])->name('createChats');
});

Route::get('/connect/{name}', function (Request $request, string $name) {
    if (config('app.env') !== 'local') return redirect()->back();

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    Auth::login(User::where('name', $name)->first());

    return to_route('dashboard');
})->name('connect');
