<?php

namespace App\Filament\Resources\Documents\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(40),
                TextColumn::make('document_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'lease_contract' => 'primary',
                        'government_id' => 'info',
                        'official_receipt' => 'success',
                        'bir_form' => 'warning',
                        'photo' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'lease_contract' => 'Lease Contract',
                        'government_id' => 'Government ID',
                        'official_receipt' => 'Official Receipt',
                        'bir_form' => 'BIR Form',
                        'photo' => 'Photo',
                        'other' => 'Other',
                        default => ucfirst($state),
                    })
                    ->sortable(),
                TextColumn::make('documentable_type')
                    ->label('Linked To')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'App\\Models\\Lease' => 'Lease',
                        'App\\Models\\Payment' => 'Payment',
                        'App\\Models\\Expense' => 'Expense',
                        'App\\Models\\MaintenanceRequest' => 'Maintenance',
                        default => $state ? class_basename($state) : '—',
                    })
                    ->placeholder('—'),
                TextColumn::make('documentable_id')
                    ->label('Record #')
                    ->placeholder('—'),
                TextColumn::make('uploadedBy.name')
                    ->label('Uploaded By')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime('M d, Y')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('document_type')
                    ->label('Type')
                    ->options([
                        'lease_contract' => 'Lease Contract',
                        'government_id' => 'Government ID',
                        'official_receipt' => 'Official Receipt',
                        'bir_form' => 'BIR Form',
                        'photo' => 'Photo',
                        'other' => 'Other',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
