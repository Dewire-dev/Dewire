<?php

namespace App\Http\Middleware;

use App\Models\Module;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => function () use ($request) {
                    if (! $user = $request->user()) {
                        return;
                    }

                    $userHasTeamFeatures = Jetstream::userHasTeamFeatures($user);

                    if ($user && $userHasTeamFeatures) {
                        $user->currentTeam;
                    }

                    return array_merge($user->toArray(), array_filter([
                        'all_teams' => $userHasTeamFeatures ? $user->allTeams()->values() : null,
                    ]), [
                        'two_factor_enabled' => Features::enabled(Features::twoFactorAuthentication())
                            && ! is_null($user->two_factor_secret),
                        'role' => $request->user()?->role(),
                        'permissions' => $request->user()?->permissions(),
                    ]);
                },
            ],
            'layout' => [
                'projects' => $request->user()?->currentTeam?->projects()->with('modules')->get(),
                'genericModules' => Module::where(['is_generic' => true])->get(),
            ],
            'isAdmin' => $request->user()?->isAdmin(),
        ]);
    }
}
