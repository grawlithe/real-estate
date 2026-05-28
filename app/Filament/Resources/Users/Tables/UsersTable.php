<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin' => 'danger',
                        'property_manager' => 'primary',
                        'accountant' => 'info',
                        'agent' => 'warning',
                        'owner' => 'success',
                        'tenant' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'super_admin' => 'Super Admin',
                        'property_manager' => 'Property Manager',
                        'accountant' => 'Accountant',
                        'agent' => 'Agent',
                        'owner' => 'Owner',
                        'tenant' => 'Tenant',
                        default => $state,
                    })
                    ->searchable(),
                TextColumn::make('kyc_status')
                    ->label('KYC Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'verified' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'verified' => 'Verified',
                        'pending' => 'Pending',
                        'rejected' => 'Rejected',
                        default => $state,
                    })
                    ->searchable(),
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
                SelectFilter::make('role')
                    ->options([
                        'super_admin' => 'Super Admin',
                        'property_manager' => 'Property Manager',
                        'accountant' => 'Accountant',
                        'agent' => 'Agent',
                        'owner' => 'Owner',
                        'tenant' => 'Tenant',
                    ]),
                SelectFilter::make('kyc_status')
                    ->label('KYC Status')
                    ->options([
                        'pending' => 'Pending',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
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
