<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TimeController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $firstDayOfWeek = clone $now->startOfWeek();
        $endDayOfWeek = clone $now->endOfWeek(CarbonInterface::FRIDAY);
        $tasks = Auth::user()->tasks()
            ->where(function($query) use ($firstDayOfWeek, $endDayOfWeek){
                $query
                    ->whereBetween('start_at', [$firstDayOfWeek, $endDayOfWeek])
                    ->orWhereBetween('end_at', [$firstDayOfWeek, $endDayOfWeek])
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

        $users = User::All();

        return Inertia::render(
            'Time/Time',
            compact(
                'tasks',
                'users',
            )
        );
    }
}
