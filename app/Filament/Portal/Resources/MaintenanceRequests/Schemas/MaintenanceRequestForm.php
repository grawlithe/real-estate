<?php

namespace App\Filament\Portal\Resources\MaintenanceRequests\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MaintenanceRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Maintenance Request Information')
                    ->description('Details regarding the required repair or service.')
                    ->columns(2)
                    ->schema([
                        Select::make('unit_id')
                            ->label('Unit')
                            ->relationship('unit', 'unit_number', function ($query) {
                                return $query->whereHas('leases', fn ($q) => 
                                    $q->where('tenant_id', auth()->id())->where('status', 'active')
                                );
                            })
                            ->required()
                            ->disabled(fn ($context) => $context !== 'create'),
                        Select::make('priority')
                            ->label('Urgency Level')
                            ->options([
                                'low' => 'Low (General improvement)',
                                'medium' => 'Medium (Needs attention soon)',
                                'high' => 'High (Disruptive to living)',
                                'urgent' => 'Urgent (Safety/Security issue)',
                            ])
                            ->required()
                            ->disabled(fn ($context) => $context !== 'create')
                            ->native(false),
                        TextInput::make('title')
                            ->label('Issue Title')
                            ->placeholder('e.g. Toilet flush not working')
                            ->required()
                            ->columnSpanFull()
                            ->disabled(fn ($context) => $context !== 'create'),
                        Textarea::make('description')
                            ->label('Detailed Description')
                            ->placeholder('Provide as much context as possible (what happened, location, when it started)...')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->disabled(fn ($context) => $context !== 'create'),
                    ]),

                Section::make('Management Updates')
                    ->description('Staff and repair updates from the operations office.')
                    ->columns(2)
                    ->visible(fn ($context) => $context !== 'create')
                    ->schema([
                        TextInput::make('status')
                            ->label('Ticket Status')
                            ->disabled(),
                        TextInput::make('assigned_to')
                            ->label('Assigned Agent')
                            ->formatStateUsing(fn ($record) => $record->assignedAgent?->name ?? 'Unassigned')
                            ->disabled(),
                        TextInput::make('estimated_cost')
                            ->label('Estimated Cost (PHP)')
                            ->numeric()
                            ->disabled(),
                        TextInput::make('actual_cost')
                            ->label('Actual Cost (PHP)')
                            ->numeric()
                            ->disabled(),
                        DatePicker::make('resolved_at')
                            ->label('Resolved Date')
                            ->disabled(),
                    ]),
            ]);
    }
}
