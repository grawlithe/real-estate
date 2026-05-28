<?php

namespace App\Filament\Portal\Resources\Invoices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Invoice Statement Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('invoice_number')
                            ->label('Invoice Number')
                            ->disabled(),
                        TextInput::make('type')
                            ->label('Invoice Type')
                            ->disabled(),
                        TextInput::make('due_date')
                            ->label('Due Date')
                            ->disabled(),
                        TextInput::make('status')
                            ->label('Payment Status')
                            ->disabled(),
                        TextInput::make('amount_due')
                            ->label('Amount Due (PHP)')
                            ->numeric()
                            ->disabled(),
                        TextInput::make('amount_paid')
                            ->label('Amount Paid (PHP)')
                            ->numeric()
                            ->disabled(),
                        Textarea::make('notes')
                            ->label('Remarks / Description')
                            ->columnSpanFull()
                            ->disabled(),
                    ]),
            ]);
    }
}
