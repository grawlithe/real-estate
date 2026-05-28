<?php

namespace App\Filament\Resources\Units\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('property_id')
                    ->relationship('property', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder('Select Property (Optional)'),
                TextInput::make('unit_number')
                    ->label('Unit Number / Code')
                    ->required()
                    ->placeholder('e.g. 101, Unit A'),
                Select::make('type')
                    ->options([
                        'condo' => 'Condominium',
                        'apartment' => 'Apartment',
                        'house' => 'House',
                        'commercial' => 'Commercial',
                    ])
                    ->required()
                    ->native(false),
                Select::make('status')
                    ->options([
                        'vacant' => 'Vacant',
                        'occupied' => 'Occupied',
                        'under_maintenance' => 'Under Maintenance',
                    ])
                    ->required()
                    ->default('vacant')
                    ->native(false),
                Select::make('ownership_type')
                    ->label('Ownership Type')
                    ->options([
                        'company_owned' => 'Company Owned',
                        'managed' => 'Sourced / Managed for Owner',
                    ])
                    ->required()
                    ->default('company_owned')
                    ->native(false),
                TextInput::make('rent_amount')
                    ->label('Monthly Rent')
                    ->required()
                    ->numeric()
                    ->prefix('₱')
                    ->placeholder('0.00'),
                TextInput::make('security_deposit')
                    ->label('Security Deposit')
                    ->required()
                    ->numeric()
                    ->prefix('₱')
                    ->placeholder('0.00'),
            ]);
    }
}
