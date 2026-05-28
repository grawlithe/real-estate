<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExpenseForm
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
                Select::make('expense_type')
                    ->label('Expense Type')
                    ->options([
                        'repairs' => 'Repairs & Maintenance',
                        'utilities' => 'Utilities',
                        'association_dues' => 'Association Dues',
                        'taxes' => 'Taxes',
                        'other' => 'Other',
                    ])
                    ->required()
                    ->native(false),
                TextInput::make('amount')
                    ->label('Amount')
                    ->required()
                    ->numeric()
                    ->prefix('₱')
                    ->placeholder('0.00'),
                DatePicker::make('expense_date')
                    ->label('Expense Date')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull()
                    ->placeholder('Detail what the expense was for...'),
                FileUpload::make('receipt_path')
                    ->label('Proof of Expense (Receipt)')
                    ->image()
                    ->directory('expense-receipts')
                    ->columnSpanFull(),
                Select::make('paid_by')
                    ->label('Paid By')
                    ->options([
                        'company' => 'Company Paid',
                        'owner' => 'Owner Deducted / Paid',
                        'tenant' => 'Tenant Paid',
                    ])
                    ->required()
                    ->default('company')
                    ->native(false),
            ]);
    }
}
