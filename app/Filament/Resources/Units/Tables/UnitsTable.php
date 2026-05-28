<?php

namespace App\Filament\Resources\Units\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UnitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('property.name')
                    ->searchable(),
                TextColumn::make('unit_number')
                    ->searchable(),
                TextColumn::make('type')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'condo' => 'Condo',
                        'apartment' => 'Apartment',
                        'house' => 'House',
                        'commercial' => 'Commercial',
                        default => ucfirst($state),
                    })
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'vacant' => 'success',
                        'occupied' => 'primary',
                        'under_maintenance' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'vacant' => 'Vacant',
                        'occupied' => 'Occupied',
                        'under_maintenance' => 'Under Maintenance',
                        default => $state,
                    })
                    ->searchable(),
                TextColumn::make('ownership_type')
                    ->label('Ownership')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'company_owned' => 'info',
                        'managed' => 'indigo',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'company_owned' => 'Company Owned',
                        'managed' => 'Managed',
                        default => $state,
                    })
                    ->searchable(),
                TextColumn::make('rent_amount')
                    ->label('Monthly Rent')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('security_deposit')
                    ->label('Security Deposit')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'vacant' => 'Vacant',
                        'occupied' => 'Occupied',
                        'under_maintenance' => 'Under Maintenance',
                    ]),
                SelectFilter::make('ownership_type')
                    ->label('Ownership')
                    ->options([
                        'company_owned' => 'Company Owned',
                        'managed' => 'Managed',
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
