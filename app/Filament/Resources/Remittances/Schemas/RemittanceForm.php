<?php

namespace App\Filament\Resources\Remittances\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RemittanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Remittance Details')
                    ->description('Record owner payout for a managed unit.')
                    ->columns(2)
                    ->schema([
                        Select::make('owner_id')
                            ->label('Unit Owner')
                            ->relationship('owner', 'name', modifyQueryUsing: fn ($query) => $query->where('role', UserRole::Owner))
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('unit_id')
                            ->label('Property Unit')
                            ->relationship('unit', 'unit_number')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->property ? "{$record->property->name} - Unit {$record->unit_number}" : "Unit {$record->unit_number}")
                            ->searchable()
                            ->preload()
                            ->required(),
                        DatePicker::make('remittance_date')
                            ->label('Remittance Date')
                            ->required()
                            ->default(now()),
                        TextInput::make('amount')
                            ->label('Amount')
                            ->required()
                            ->numeric()
                            ->prefix('₱')
                            ->placeholder('0.00'),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'processed' => 'Processed',
                                'released' => 'Released',
                            ])
                            ->required()
                            ->default('pending')
                            ->native(false),
                        TextInput::make('pdf_path')
                            ->label('Statement PDF Path')
                            ->placeholder('Auto-generated on release')
                            ->disabled()
                            ->dehydrated(),
                    ]),
                Section::make('Notes')
                    ->collapsed()
                    ->schema([
                        Textarea::make('notes')
                            ->placeholder('Optional notes about this remittance...')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
