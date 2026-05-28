<?php

namespace App\Filament\Resources\Invoices\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('lease_id')
                    ->label('Lease Contract')
                    ->relationship('lease', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "Lease #{$record->id} (Unit {$record->unit->unit_number} - {$record->tenant->name})")
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('tenant_id')
                    ->label('Tenant')
                    ->relationship('tenant', 'name', modifyQueryUsing: fn ($query) => $query->where('role', UserRole::Tenant))
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('invoice_number')
                    ->label('Invoice Number')
                    ->required()
                    ->default(fn () => 'INV-'.date('Y').'-'.strtoupper(bin2hex(random_bytes(3))))
                    ->placeholder('e.g. INV-2026-A1'),
                DatePicker::make('due_date')
                    ->label('Due Date')
                    ->required(),
                TextInput::make('amount_due')
                    ->label('Amount Due')
                    ->required()
                    ->numeric()
                    ->prefix('₱')
                    ->placeholder('0.00'),
                TextInput::make('amount_paid')
                    ->label('Amount Paid')
                    ->required()
                    ->numeric()
                    ->prefix('₱')
                    ->default(0.00),
                Select::make('status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'partially_paid' => 'Partially Paid',
                        'paid' => 'Paid',
                        'overdue' => 'Overdue',
                    ])
                    ->required()
                    ->default('unpaid')
                    ->native(false),
                Select::make('type')
                    ->options([
                        'rent' => 'Rent',
                        'utility' => 'Utility',
                        'late_fee' => 'Late Fee',
                        'security_deposit' => 'Security Deposit',
                        'other' => 'Other',
                    ])
                    ->required()
                    ->default('rent')
                    ->native(false),
                TextInput::make('late_fee_applied')
                    ->label('Late Fee Applied')
                    ->required()
                    ->numeric()
                    ->prefix('₱')
                    ->default(0.00),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
