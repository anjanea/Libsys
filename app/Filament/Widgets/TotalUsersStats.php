<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;

class TotalUsersStats extends StatsOverviewWidget
{
    public function getColumns(): int | array
    {
        return 1;
    }

    protected int | string | array $columnSpan = 1;
    
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->icon('heroicon-o-users'),
        ];
    }
}
