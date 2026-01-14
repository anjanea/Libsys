<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Loan;
use App\Models\Book;

class LoanStats extends StatsOverviewWidget
{
    public function getColumns(): int | array
    {
        return 1;
    }

    protected int | string | array $columnSpan = 1;

    protected function getStats(): array
    {
        return [
            Stat::make(
                'Active Loans',
                Loan::where('status', 'borrowed')->count()
            )
                ->icon('heroicon-o-book-open'),

            Stat::make(
                'Low Stock Books',
                Book::where('available_copies', '<=', 2)->count()
            )
                ->icon('heroicon-o-exclamation-triangle'),

            Stat::make(
                'Overdue Loans',
                Loan::where('status', 'borrowed')
                    ->where('due_date', '<', now())
                    ->count()
            )
                ->icon('heroicon-o-clock'),
        ];
    }
}
