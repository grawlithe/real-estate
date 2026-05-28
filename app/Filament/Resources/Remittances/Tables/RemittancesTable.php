<?php

namespace App\Filament\Resources\Remittances\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RemittancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('owner.name')
                    ->label('Owner')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('unit.unit_number')
                    ->label('Unit')
                    ->formatStateUsing(fn ($record) => $record->unit?->property ? "{$record->unit->property->name} - {$record->unit->unit_number}" : $record->unit?->unit_number)
                    ->searchable(),
                TextColumn::make('remittance_date')
                    ->label('Date')
                    ->date('M d, Y')
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'processed' => 'info',
                        'released' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('remittance_date', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processed' => 'Processed',
                        'released' => 'Released',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
