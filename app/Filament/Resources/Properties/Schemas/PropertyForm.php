<?php

namespace App\Filament\Resources\Properties\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PropertyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Property Details')
                    ->description('Core information about the property or building.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Property Name')
                            ->required()
                            ->placeholder('e.g. Sunrise Residences, Tower A'),
                        TextInput::make('address')
                            ->label('Full Address')
                            ->required()
                            ->placeholder('e.g. 123 Rizal Ave, Makati City')
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Description / Notes')
                            ->placeholder('Additional details about the property, amenities, location notes...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
