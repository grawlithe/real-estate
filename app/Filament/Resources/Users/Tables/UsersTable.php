<?php

namespace App\Filament\Resources\Users\Tables;

use App\Enums\UserRole;
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
                    ->color(fn (UserRole $state): string => match ($state) {
                        UserRole::SuperAdmin => 'danger',
                        UserRole::PropertyManager => 'primary',
                        UserRole::Accountant => 'info',
                        UserRole::Agent => 'warning',
                        UserRole::Owner => 'success',
                        UserRole::Tenant => 'gray',
                    })
                    ->formatStateUsing(fn (UserRole $state): string => match ($state) {
                        UserRole::SuperAdmin => 'Super Admin',
                        UserRole::PropertyManager => 'Property Manager',
                        UserRole::Accountant => 'Accountant',
                        UserRole::Agent => 'Agent',
                        UserRole::Owner => 'Owner',
                        UserRole::Tenant => 'Tenant',
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
