<?php

namespace App\Filament\Resources\MaintenanceRequests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MaintenanceRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Issue')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(40),
                TextColumn::make('unit.unit_number')
                    ->label('Unit')
                    ->formatStateUsing(fn ($record) => $record->unit?->property ? "{$record->unit->property->name} - {$record->unit->unit_number}" : $record->unit?->unit_number)
                    ->searchable(),
                TextColumn::make('tenant.name')
                    ->label('Reported By')
                    ->searchable(),
                TextColumn::make('assignedTo.name')
                    ->label('Assigned To')
                    ->placeholder('Unassigned')
                    ->searchable(),
                TextColumn::make('priority')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'urgent' => 'danger',
                        'high' => 'warning',
                        'medium' => 'info',
                        'low' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'in_progress' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'in_progress' => 'In Progress',
                        default => ucfirst($state),
                    })
                    ->sortable(),
                TextColumn::make('estimated_cost')
                    ->label('Est. Cost')
                    ->money('PHP')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('actual_cost')
                    ->label('Actual Cost')
                    ->money('PHP')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('resolved_at')
                    ->label('Resolved')
                    ->dateTime('M d, Y h:i A')
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                SelectFilter::make('priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                        'urgent' => 'Urgent',
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
