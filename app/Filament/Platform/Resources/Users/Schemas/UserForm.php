<?php

namespace App\Filament\Platform\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->placeholder('Full Name'),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('email@example.com'),
                        Select::make('role')
                            ->options(array_combine(
                                array_map(fn ($r) => $r->value, UserRole::cases()),
                                array_map(fn ($r) => ucwords(str_replace('_', ' ', $r->value)), UserRole::cases())
                            ))
                            ->required()
                            ->native(false),
                        Select::make('kyc_status')
                            ->label('KYC Status')
                            ->options([
                                'pending' => 'Pending Verification',
                                'verified' => 'Verified KYC',
                                'rejected' => 'Rejected',
                            ])
                            ->required()
                            ->default('pending')
                            ->native(false),
                        TextInput::make('password')
                            ->password()
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn ($livewire) => $livewire instanceof CreateRecord)
                            ->placeholder('••••••••'),
                        KeyValue::make('kyc_data')
                            ->label('KYC Document & Metadata')
                            ->keyLabel('Field Name')
                            ->valueLabel('Value / Number')
                            ->columnSpanFull(),
                    ]),

                Section::make('Company Assignments')
                    ->description('Assign this user to one or more Property Management Companies (PMCs).')
                    ->schema([
                        CheckboxList::make('companies')
                            ->relationship('companies', 'name')
                            ->searchable()
                            ->bulkToggleable(),
                    ]),
            ]);
    }
}
