<?php

namespace App\Filament\Portal\Resources\Units\Schemas;

use Carbon\Carbon;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Unit Information')
                    ->columns(2)
                    ->schema([
                        TextInput::make('property.name')
                            ->label('Property / Building')
                            ->disabled(),
                        TextInput::make('unit_number')
                            ->label('Unit Number')
                            ->disabled(),
                        TextInput::make('type')
                            ->label('Unit Type')
                            ->formatStateUsing(fn ($state) => ucwords($state))
                            ->disabled(),
                        TextInput::make('status')
                            ->label('Operational Status')
                            ->formatStateUsing(fn ($state) => ucwords(str_replace('_', ' ', $state)))
                            ->disabled(),
                        TextInput::make('rent_amount')
                            ->label('Monthly Rental Amount (PHP)')
                            ->numeric()
                            ->disabled(),
                        TextInput::make('security_deposit')
                            ->label('Security Deposit (PHP)')
                            ->numeric()
                            ->disabled(),
                    ]),

                Section::make('Active Tenant & Lease Contract (Privacy Filtered)')
                    ->description('Conceals PII (email, phone, official KYC forms) in compliance with real estate data privacy standards.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('tenant_name')
                            ->label('Active Tenant Name')
                            ->formatStateUsing(fn ($record) => $record->activeLease?->tenant?->name ?? 'No active tenant (Vacant)')
                            ->disabled(),
                        TextInput::make('lease_dates')
                            ->label('Contract Duration')
                            ->formatStateUsing(fn ($record) => $record->activeLease
                                ? Carbon::parse($record->activeLease->start_date)->format('M d, Y').' - '.Carbon::parse($record->activeLease->end_date)->format('M d, Y')
                                : 'N/A'
                            )
                            ->disabled(),
                        TextInput::make('rent_status')
                            ->label('Rent Collection Status')
                            ->formatStateUsing(fn ($record) => $record->activeLease
                                ? ($record->activeLease->invoices->where('status', 'paid')->count().' of '.$record->activeLease->invoices->count().' statements paid')
                                : 'N/A'
                            )
                            ->disabled(),
                        TextInput::make('disclaimer')
                            ->label('Privacy Notice')
                            ->default('KYC Verification Files and Contact details are encrypted & secured.')
                            ->disabled(),
                    ]),
            ]);
    }
}
