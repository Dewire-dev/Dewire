<?php

namespace App\Http\Controllers;

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
        $firstDayOfWeek = clone $now->startOfWeek();
        $lastDayOfWeek = clone $now->endOfWeek(CarbonInterface::FRIDAY);

        $tasks = $this->getTasks($firstDayOfWeek, $lastDayOfWeek);
        $users = User::All();

        return Inertia::render(
            'Time/Time',
            [
                'tasks' => $tasks,
                'users' => $users,
                'firstDayOfWeek' => $firstDayOfWeek,
                'lastDayOfWeek' => $lastDayOfWeek,
            ],
        );
    }

    public function getPreviousWeek (Request $request): JsonResponse
    {
        $date = new Carbon($request->get('date'));
        $date->addWeeks(-1);
        $firstDayOfPreviousWeek = clone $date->startOfWeek();
        $lastDayOfPreviousWeek = clone $date->endOfWeek(CarbonInterface::FRIDAY);
        return response()->json([
            'tasks' => $this->getTasks($firstDayOfPreviousWeek, $lastDayOfPreviousWeek),
            'firstDay' => $firstDayOfPreviousWeek,
            'lastDay' => $lastDayOfPreviousWeek,
        ]);
    }

    public function getNextWeek (Request $request): JsonResponse
    {
        $date = new Carbon($request->get('date'));
        $firstDayOfNextWeek = clone $date->addWeek()->startOfWeek();
        $lastDayOfNextWeek = clone $date->endOfWeek(CarbonInterface::FRIDAY);
        return response()->json([
            'tasks' => $this->getTasks($firstDayOfNextWeek, $lastDayOfNextWeek),
            'firstDay' => $firstDayOfNextWeek,
            'lastDay' => $lastDayOfNextWeek,
        ]);
    }

    private function getTasks (\DateTimeInterface $firstDayOfWeek, \DateTimeInterface $lastDayOfWeek)
    {
        return Auth::user()->tasks()
            ->where(function($query) use ($firstDayOfWeek, $lastDayOfWeek){
                $query
                    ->whereBetween('start_at', [$firstDayOfWeek, $lastDayOfWeek])
                    ->orWhereBetween('end_at', [$firstDayOfWeek, $lastDayOfWeek])
                ;
            })
            ->with([
                'project',
                'taskTimeSpends' => function($q){
                    $q->where('user_id', '=', Auth::user()->getAuthIdentifier());
                },
            ])
            ->get()
        ;
    }
}
