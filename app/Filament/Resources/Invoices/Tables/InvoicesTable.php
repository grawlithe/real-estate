<?php

namespace App\Filament\Resources\Invoices\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lease.unit.unit_number')
                    ->label('Unit')
                    ->formatStateUsing(fn ($record) => $record->lease->unit->property ? "{$record->lease->unit->property->name} - Unit {$record->lease->unit->unit_number}" : "Unit {$record->lease->unit->unit_number}")
                    ->searchable(),
                TextColumn::make('tenant.name')
                    ->label('Tenant')
                    ->searchable(),
                TextColumn::make('invoice_number')
                    ->label('Invoice Number')
                    ->searchable(),
                TextColumn::make('due_date')
                    ->label('Due Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('amount_due')
                    ->label('Amount Due')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('amount_paid')
                    ->label('Amount Paid')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'unpaid' => 'warning',
                        'overdue' => 'danger',
                        'partially_paid' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'paid' => 'Paid',
                        'unpaid' => 'Unpaid',
                        'overdue' => 'Overdue',
                        'partially_paid' => 'Partially Paid',
                        default => ucfirst($state),
                    })
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'rent' => 'Rent',
                        'utility' => 'Utility',
                        'late_fee' => 'Late Fee',
                        'security_deposit' => 'Security Deposit',
                        'other' => 'Other',
                        default => ucfirst($state),
                    })
                    ->searchable(),
                TextColumn::make('late_fee_applied')
                    ->label('Late Fee')
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
                        'unpaid' => 'Unpaid',
                        'partially_paid' => 'Partially Paid',
                        'paid' => 'Paid',
                        'overdue' => 'Overdue',
                    ]),
                SelectFilter::make('type')
                    ->options([
                        'rent' => 'Rent',
                        'utility' => 'Utility',
                        'late_fee' => 'Late Fee',
                        'security_deposit' => 'Security Deposit',
                        'other' => 'Other',
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
