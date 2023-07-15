<?php

namespace App\Http\Controllers;

use App\Enum\TaskState;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TimeController extends Controller
{
    public function index(Request $request): Response
    {
        $now = Carbon::now();
        $user = $request->get('user') ? User::find($request->get('user')) : Auth::user();
        $firstDayOfWeek = clone $now->startOfWeek();
        $lastDayOfWeek = clone $now->endOfWeek(CarbonInterface::FRIDAY);

        $tasks = $this->getTasks($firstDayOfWeek, $lastDayOfWeek, $user);
        $users = User::All();

        return Inertia::render(
            'Time/Time',
            [
                'currentUserSelected' => $user,
                'userConnected' => Auth::user(),
                'tasks' => $tasks,
                'states' => array_column(TaskState::cases(), 'value'),
                'users' => $users,
                'firstDayOfWeek' => $firstDayOfWeek,
                'lastDayOfWeek' => $lastDayOfWeek,
            ],
        );
    }

    public function getPreviousWeek (Request $request): JsonResponse
    {
        $date = new Carbon($request->get('date'));
        $user = $request->get('user') ? User::find($request->get('user')) : Auth::user();
        $date->addWeeks(-1);
        $firstDayOfPreviousWeek = clone $date->startOfWeek();
        $lastDayOfPreviousWeek = clone $date->endOfWeek(CarbonInterface::FRIDAY);
        return response()->json([
            'currentUserSelected' => $user,
            'tasks' => $this->getTasks($firstDayOfPreviousWeek, $lastDayOfPreviousWeek, $user),
            'firstDay' => $firstDayOfPreviousWeek,
            'lastDay' => $lastDayOfPreviousWeek,
        ]);
    }

    public function getNextWeek (Request $request): JsonResponse
    {
        $date = new Carbon($request->get('date'));
        $user = $request->get('user') ? User::find($request->get('user')) : Auth::user();
        $firstDayOfNextWeek = clone $date->addWeek()->startOfWeek();
        $lastDayOfNextWeek = clone $date->endOfWeek(CarbonInterface::FRIDAY);
        return response()->json([
            'currentUserSelected' => $user,
            'tasks' => $this->getTasks($firstDayOfNextWeek, $lastDayOfNextWeek, $user),
            'firstDay' => $firstDayOfNextWeek,
            'lastDay' => $lastDayOfNextWeek,
        ]);
    }

    public function getTasksByUser(Request $request): JsonResponse
    {
        $date = new Carbon($request->get('date'));
        $user = $request->get('user') ? User::find($request->get('user')) : Auth::user();
        $firstDayOfWeek = clone $date->startOfWeek();
        $lastDayOfWeek = clone $date->endOfWeek(CarbonInterface::FRIDAY);

        $tasks = $this->getTasks($firstDayOfWeek, $lastDayOfWeek, $user);
        $users = User::All();

        return response()->json([
            'currentUserSelected' => $user,
            'tasks' => $tasks,
            'users' => $users,
            'firstDayOfWeek' => $firstDayOfWeek,
            'lastDayOfWeek' => $lastDayOfWeek,
        ]);
    }

    private function getTasks (\DateTimeInterface $firstDayOfWeek, \DateTimeInterface $lastDayOfWeek, User $user)
    {
        return $user->tasks()
            ->where(function($query) use ($firstDayOfWeek, $lastDayOfWeek){
                $query
                    ->whereBetween('start_at', [$firstDayOfWeek, $lastDayOfWeek])
                    ->orWhereBetween('end_at', [$firstDayOfWeek, $lastDayOfWeek])
                ;
            })
            ->with([
                'project',
                'taskTimeSpends' => function($q) use ($user){
                    $q->where('user_id', '=', $user->getAuthIdentifier());
                },
            ])
            ->get()
        ;
    }
}
