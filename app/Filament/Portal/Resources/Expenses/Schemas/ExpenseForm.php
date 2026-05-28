<?php

namespace App\Filament\Portal\Resources\Expenses\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Expense Transaction Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('unit_number')
                            ->label('Unit')
                            ->formatStateUsing(fn ($record) => ($record->unit?->property?->name ?? 'N/A') . ' - Unit ' . ($record->unit?->unit_number ?? 'N/A'))
                            ->disabled(),
                        TextInput::make('expense_type')
                            ->label('Expense Type')
                            ->formatStateUsing(fn ($state) => ucwords(str_replace('_', ' ', $state)))
                            ->disabled(),
                        TextInput::make('amount')
                            ->label('Amount (PHP)')
                            ->numeric()
                            ->disabled(),
                        TextInput::make('expense_date')
                            ->label('Transaction Date')
                            ->disabled(),
                        TextInput::make('paid_by')
                            ->label('Settled By')
                            ->formatStateUsing(fn ($state) => ucwords($state))
                            ->disabled(),
                        Textarea::make('description')
                            ->label('Expense Description')
                            ->columnSpanFull()
                            ->disabled(),
                        FileUpload::make('receipt_path')
                            ->label('Receipt Attachment')
                            ->image()
                            ->columnSpanFull()
                            ->disabled(),
                    ]),
            ]);
    }
}
