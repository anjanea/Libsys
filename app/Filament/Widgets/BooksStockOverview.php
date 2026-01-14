<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Loan;

class BooksStockOverview extends StatsOverviewWidget
{
    public function getColumns(): int | array
    {
        return 1;
    }

    protected int | string | array $columnSpan = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Titles', Book::count())
                ->icon('heroicon-o-book-open')
                ->color('emerald'),

            Stat::make('Available Copies', Book::sum('available_copies'))
                ->icon('heroicon-o-archive-box'),

            Stat::make(
                'Active Borrowers',
                Loan::where('status', 'borrowed')
                    ->distinct('user_id')
                    ->count('user_id')
            )
                ->icon('heroicon-o-users'),
        ];
    }
}
