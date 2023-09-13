<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\TaskTimeSpend;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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
    public function update(TaskRequest $request, Task $task)
    {
        $task->update([
            'state' => $request->get('state'),
            'description' => $request->get('description'),
        ]);

        return $this->show($task);
    }

    public function updateTaskTimeSpends(Request $request, Task $task)
    {
        $taskTimeSpends = $request->get('taskTimeSpends');
        $user = Auth::user();
        $dateNow = new \DateTime();

        foreach ($taskTimeSpends as $taskTimeSpendData) {
            $taskTimeSpendId = $taskTimeSpendData['id'] ?? null;
            $taskTimeSpend = TaskTimeSpend::updateOrCreate([
                'id' => $taskTimeSpendId,
            ], [
                'user_id' => $user->id,
                'task_id' => $task->id,
                'date' => $taskTimeSpendId
                    ? new \DateTime($taskTimeSpendData['date'])
                    : (new \DateTime($taskTimeSpendData['date']))
                        ->setTime(
                            $dateNow->format('H'),
                            $dateNow->format('i')
                        ),
                'time' => $taskTimeSpendData['time'],
                'description' => $taskTimeSpendData['description'],
            ]);
            $task->taskTimeSpends()->save($taskTimeSpend);
        }
    }

    public function deleteTaskTimeSpend(Task $task, TaskTimeSpend $taskTimeSpend)
    {
        $user = Auth::user();

        if ($taskTimeSpend->user->id !== $user->id) {
            throw new AccessDeniedHttpException('Vous ne pouvez pas supprimer la saisie d\'une autre personne');
        }

        TaskTimeSpend::where('id', $taskTimeSpend->id)
            ->where('user_id', $user->id)
            ->where('task_id', $task->id)
            ->delete()
        ;
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

    public function deleteComment(Task $task, TaskComment $taskComment)
    {
        $taskComment->delete();

        return $this->show($task);
    }
}
