<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $tasks = Task::all();
        return response()->json([
            'task' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load(['project', 'userCreator', 'users', 'taskComments', 'taskComments.user', 'taskTimeSpends']);
        return response()->json([
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
    }

    public function taskTimeSpends(Task $task, string $date, User $user)
    {
        $task->load(['project']);
        return response()->json([
            'task' => $task,
            'taskTimeSpends' => $task->taskTimeSpends()
                ->whereDate('date', $date)
                ->where('user_id', $user->id)
                ->get(),
        ]);
    }

    public function addComment(Request $request, Task $task)
    {
        $user = Auth::user();
        $task->taskComments()->create([
            'user_id' => $user->id,
            'task_id' => $task->id,
            'comment' => $request->get('comment'),
        ]);

        return $this->show($task);
    }
}
