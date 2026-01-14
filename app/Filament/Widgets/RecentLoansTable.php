<?php

namespace App\Filament\Widgets;

use App\Models\Loan;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;

class RecentLoansTable extends TableWidget
{
    protected static ?string $heading = 'Recent Loan Activity';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Loan::query()->latest()
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('Member')
                    ->searchable(),

                TextColumn::make('book.title')
                    ->label('Book')
                    ->limit(30),

                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'returned',
                        'warning' => 'borrowed',
                        'danger' => 'overdue',
                    ]),

                TextColumn::make('borrow_date')
                    ->label('Borrowed')
                    ->date(),
            ])
            ->defaultSort('borrow_date', 'desc')
            ->paginated([5]);
    }
}
