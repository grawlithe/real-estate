<?php

namespace App\Filament\Platform\Resources\Companies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Company Details')
                    ->description('Information about the Property Management Company / Tenant.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Company Name')
                            ->required()
                            ->placeholder('e.g. Apex Estate Management')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($get, $set, ?string $operation, ?string $state) {
                                if ($operation === 'edit') {
                                    return;
                                }
                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('slug')
                            ->label('Slug / URL Identifier')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('e.g. apex-estate'),
                    ]),
            ]);
    }
}
