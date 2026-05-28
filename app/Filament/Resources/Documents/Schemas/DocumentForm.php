<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Document Details')
                    ->description('Upload and classify documents for record keeping.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Document Title')
                            ->required()
                            ->placeholder('e.g. Lease Agreement - Unit 101'),
                        Select::make('document_type')
                            ->label('Document Type')
                            ->options([
                                'lease_contract' => 'Lease Contract',
                                'government_id' => 'Government ID',
                                'official_receipt' => 'Official Receipt',
                                'bir_form' => 'BIR Form',
                                'photo' => 'Photo / Attachment',
                                'other' => 'Other',
                            ])
                            ->required()
                            ->native(false),
                        FileUpload::make('file_path')
                            ->label('File')
                            ->required()
                            ->directory('document-vault')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(10240)
                            ->columnSpanFull(),
                    ]),

                Section::make('Linked Record')
                    ->description('Optionally link this document to a specific lease, payment, or expense.')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        Select::make('documentable_type')
                            ->label('Link To')
                            ->options([
                                'App\\Models\\Lease' => 'Lease',
                                'App\\Models\\Payment' => 'Payment',
                                'App\\Models\\Expense' => 'Expense',
                                'App\\Models\\MaintenanceRequest' => 'Maintenance Request',
                            ])
                            ->placeholder('Select a record type')
                            ->native(false)
                            ->reactive(),
                        TextInput::make('documentable_id')
                            ->label('Record ID')
                            ->numeric()
                            ->placeholder('e.g. 1'),
                        Select::make('uploaded_by')
                            ->label('Uploaded By')
                            ->relationship('uploadedBy', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->default(fn () => auth()->id()),
                    ]),
            ]);
    }
}
