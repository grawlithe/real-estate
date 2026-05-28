<?php

namespace App\Filament\Resources\MaintenanceRequests\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\DateTimePicker;
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
                Section::make('Ticket Information')
                    ->description('What needs to be fixed and where.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Issue Title')
                            ->required()
                            ->placeholder('e.g. Leaking faucet in kitchen')
                            ->columnSpanFull(),
                        Select::make('unit_id')
                            ->label('Property Unit')
                            ->relationship('unit', 'unit_number')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->property ? "{$record->property->name} - Unit {$record->unit_number}" : "Unit {$record->unit_number}")
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('tenant_id')
                            ->label('Reported By (Tenant)')
                            ->relationship('tenant', 'name', modifyQueryUsing: fn ($query) => $query->where('role', UserRole::Tenant))
                            ->searchable()
                            ->preload()
                            ->required(),
                        Textarea::make('description')
                            ->label('Detailed Description')
                            ->required()
                            ->rows(3)
                            ->placeholder('Describe the issue in detail...')
                            ->columnSpanFull(),
                    ]),

                Section::make('Assignment & Priority')
                    ->description('Assign staff and set urgency level.')
                    ->columns(2)
                    ->schema([
                        Select::make('assigned_to')
                            ->label('Assigned To')
                            ->relationship('assignedTo', 'name', modifyQueryUsing: fn ($query) => $query->whereIn('role', [UserRole::PropertyManager, UserRole::Agent]))
                            ->searchable()
                            ->preload()
                            ->placeholder('Select staff member'),
                        Select::make('priority')
                            ->options([
                                'low' => 'Low',
                                'medium' => 'Medium',
                                'high' => 'High',
                                'urgent' => 'Urgent',
                            ])
                            ->required()
                            ->default('medium')
                            ->native(false),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'in_progress' => 'In Progress',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->default('pending')
                            ->native(false),
                        DateTimePicker::make('resolved_at')
                            ->label('Resolved At'),
                    ]),

                Section::make('Cost Tracking')
                    ->description('Track estimated vs. actual repair costs.')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        TextInput::make('estimated_cost')
                            ->label('Estimated Cost')
                            ->numeric()
                            ->prefix('₱')
                            ->placeholder('0.00'),
                        TextInput::make('actual_cost')
                            ->label('Actual Cost')
                            ->numeric()
                            ->prefix('₱')
                            ->placeholder('0.00'),
                    ]),
            ]);
    }
}
