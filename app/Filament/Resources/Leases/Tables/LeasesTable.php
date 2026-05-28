<?php

namespace App\Filament\Resources\Leases\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LeasesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unit.unit_number')
                    ->label('Unit')
                    ->formatStateUsing(fn ($record) => $record->unit->property ? "{$record->unit->property->name} - Unit {$record->unit->unit_number}" : "Unit {$record->unit->unit_number}")
                    ->searchable(),
                TextColumn::make('tenant.name')
                    ->label('Tenant')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label('Start')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('End')
                    ->date()
                    ->sortable(),
                TextColumn::make('rent_amount')
                    ->label('Monthly Rent')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('security_deposit')
                    ->label('Security Deposit')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'pending' => 'warning',
                        'terminated' => 'danger',
                        'expired' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->searchable(),
                TextColumn::make('move_in_date')
                    ->label('Move-In')
                    ->date()
                    ->sortable(),
                TextColumn::make('move_out_date')
                    ->label('Move-Out')
                    ->date()
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
                        'pending' => 'Pending',
                        'active' => 'Active',
                        'terminated' => 'Terminated',
                        'expired' => 'Expired',
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
