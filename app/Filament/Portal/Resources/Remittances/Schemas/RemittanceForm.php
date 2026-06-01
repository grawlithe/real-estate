<?php

namespace App\Filament\Portal\Resources\Remittances\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RemittanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Payout Statement Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('unit')
                            ->label('Property Unit')
                            ->formatStateUsing(fn ($record) => ($record->unit?->property?->name ?? 'N/A').' - Unit '.($record->unit?->unit_number ?? 'N/A'))
                            ->disabled(),
                        TextInput::make('amount')
                            ->label('Remitted Amount (PHP)')
                            ->numeric()
                            ->disabled(),
                        DatePicker::make('remittance_date')
                            ->label('Payout Date')
                            ->disabled(),
                        TextInput::make('status')
                            ->label('Payout Status')
                            ->disabled(),
                        FileUpload::make('pdf_path')
                            ->label('Statement Document (PDF)')
                            ->columnSpanFull()
                            ->disabled(),
                    ]),
            ]);
    }
}
