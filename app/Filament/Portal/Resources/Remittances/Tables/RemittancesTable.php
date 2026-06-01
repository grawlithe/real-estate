<?php

namespace App\Filament\Portal\Resources\Remittances\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RemittancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unit.unit_number')
                    ->label('Property Unit')
                    ->formatStateUsing(fn ($record) => ($record->unit?->property?->name ?? 'N/A').' - Unit '.($record->unit?->unit_number ?? 'N/A'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('remittance_date')
                    ->label('Payout Date')
                    ->date('M d, Y')
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Remitted Amount')
                    ->money('PHP')
                    ->weight('bold')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Transfer Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'transferred' => 'success',
                        'processed' => 'info',
                        'pending' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucwords($state))
                    ->sortable(),
            ])
            ->defaultSort('remittance_date', 'desc')
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
