<?php

namespace App\Filament\Widgets;

use App\Models\Module;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Utilisateurs', User::count()),
            Stat::make('Équipes', Team::count()),
            Stat::make('Projets', Project::count()),
            Stat::make('Modules', Module::count()),
        ];
    }
}
