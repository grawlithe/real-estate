<?php

namespace App\Filament\Resources\Leases\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LeaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('unit_id')
                    ->label('Property Unit')
                    ->relationship('unit', 'unit_number')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->property ? "{$record->property->name} - Unit {$record->unit_number}" : "Unit {$record->unit_number}")
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('tenant_id')
                    ->label('Tenant')
                    ->relationship('tenant', 'name', modifyQueryUsing: fn ($query) => $query->where('role', UserRole::Tenant))
                    ->searchable()
                    ->preload()
                    ->required(),
                DatePicker::make('start_date')
                    ->label('Lease Start')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('Lease End')
                    ->required(),
                TextInput::make('rent_amount')
                    ->label('Rent Amount')
                    ->required()
                    ->numeric()
                    ->prefix('₱'),
                TextInput::make('security_deposit')
                    ->label('Security Deposit')
                    ->required()
                    ->numeric()
                    ->prefix('₱'),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'active' => 'Active',
                        'terminated' => 'Terminated',
                        'expired' => 'Expired',
                    ])
                    ->required()
                    ->default('pending')
                    ->native(false),
                DatePicker::make('move_in_date')
                    ->label('Move-In Date'),
                DatePicker::make('move_out_date')
                    ->label('Move-Out Date'),
                Textarea::make('terms')
                    ->columnSpanFull(),
            ]);
    }
}
