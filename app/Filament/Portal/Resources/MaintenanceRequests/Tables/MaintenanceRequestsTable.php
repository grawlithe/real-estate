<?php

namespace App\Filament\Portal\Resources\MaintenanceRequests\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MaintenanceRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Request Issue')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('unit.unit_number')
                    ->label('Unit Number')
                    ->formatStateUsing(fn ($record) => ($record->unit?->property?->name ?? 'N/A') . ' - Unit ' . ($record->unit?->unit_number ?? 'N/A'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('priority')
                    ->label('Urgency')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'low' => 'gray',
                        'medium' => 'info',
                        'high' => 'warning',
                        'urgent' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucwords($state))
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'assigned' => 'info',
                        'in_progress' => 'amber',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucwords(str_replace('_', ' ', $state)))
                    ->sortable(),
                TextColumn::make('assignedAgent.name')
                    ->label('Assigned Staff')
                    ->default('Unassigned')
                    ->searchable(),
                TextColumn::make('resolved_at')
                    ->label('Resolved')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
