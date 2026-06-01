<?php

namespace App\Filament\Portal\Resources\Units\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UnitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unit_number')
                    ->label('Unit Number')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('property.name')
                    ->label('Property / Building')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (string $state): string => ucwords($state))
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'vacant' => 'gray',
                        'occupied' => 'success',
                        'under_maintenance' => 'amber',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucwords(str_replace('_', ' ', $state)))
                    ->sortable(),
                TextColumn::make('rent_amount')
                    ->label('Monthly Rent')
                    ->money('PHP')
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('activeLease.tenant.name')
                    ->label('Occupied By')
                    ->default('Vacant')
                    ->searchable(),
            ])
            ->defaultSort('unit_number', 'asc')
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
