<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->placeholder('Full Name'),
                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->placeholder('email@example.com'),
                Select::make('role')
                    ->options([
                        'super_admin' => 'Super Admin',
                        'property_manager' => 'Property Manager',
                        'accountant' => 'Accountant',
                        'agent' => 'Agent',
                        'owner' => 'Property Owner',
                        'tenant' => 'Tenant',
                    ])
                    ->default('tenant')
                    ->required()
                    ->native(false),
                Select::make('kyc_status')
                    ->label('KYC Status')
                    ->options([
                        'pending' => 'Pending Verification',
                        'verified' => 'Verified KYC',
                        'rejected' => 'Rejected',
                    ])
                    ->required()
                    ->default('pending')
                    ->native(false),
                TextInput::make('password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->placeholder('••••••••'),
                KeyValue::make('kyc_data')
                    ->label('KYC Document & Metadata')
                    ->keyLabel('Field Name')
                    ->valueLabel('Value / Number')
                    ->columnSpanFull(),
            ]);
    }
}
