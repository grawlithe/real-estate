<?php

namespace App\Filament\Portal\Resources\Expenses\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unit.unit_number')
                    ->label('Property Unit')
                    ->formatStateUsing(fn ($record) => ($record->unit?->property?->name ?? 'N/A') . ' - Unit ' . ($record->unit?->unit_number ?? 'N/A'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('expense_type')
                    ->label('Expense Category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'repairs' => 'danger',
                        'utilities' => 'info',
                        'association_dues' => 'warning',
                        'taxes' => 'primary',
                        'maintenance' => 'amber',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucwords(str_replace('_', ' ', $state)))
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Expense Amount')
                    ->money('PHP')
                    ->weight('bold')
                    ->sortable(),
                TextColumn::make('expense_date')
                    ->label('Transaction Date')
                    ->date('M d, Y')
                    ->sortable(),
                TextColumn::make('paid_by')
                    ->label('Paid By')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'company' => 'primary',
                        'owner' => 'success',
                        'tenant' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucwords($state))
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50),
            ])
            ->defaultSort('expense_date', 'desc')
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
