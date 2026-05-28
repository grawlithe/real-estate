<?php

namespace App\Filament\Portal\Resources\Invoices\Tables;

use App\Models\Invoice;
use App\Models\Payment;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->label('Invoice Number')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('type')
                    ->label('Billing Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'rent' => 'primary',
                        'utility' => 'warning',
                        'late_fee' => 'danger',
                        'security_deposit' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucwords($state)),
                TextColumn::make('lease.unit.property.name')
                    ->label('Property Unit')
                    ->formatStateUsing(fn ($record) => ($record->lease?->unit?->property?->name ?? 'N/A') . ' - Unit ' . ($record->lease?->unit?->unit_number ?? 'N/A'))
                    ->searchable(),
                TextColumn::make('due_date')
                    ->label('Due Date')
                    ->date('M d, Y')
                    ->sortable(),
                TextColumn::make('amount_due')
                    ->label('Amount Due')
                    ->money('PHP')
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('amount_paid')
                    ->label('Amount Paid')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Payment Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'unpaid' => 'warning',
                        'partially_paid' => 'amber',
                        'overdue' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucwords(str_replace('_', ' ', $state)))
                    ->sortable(),
            ])
            ->defaultSort('due_date', 'desc')
            ->recordActions([
                ViewAction::make(),
                Action::make('pay')
                    ->label('Pay Now')
                    ->icon('heroicon-o-credit-card')
                    ->color('success')
                    ->visible(fn (Invoice $record): bool => 
                        auth()->user()?->isTenant() && 
                        in_array($record->status, ['unpaid', 'overdue', 'partially_paid'])
                    )
                    ->form([
                        Select::make('channel')
                            ->label('Payment Channel')
                            ->options([
                                'gcash' => 'GCash (Mock Wallet)',
                                'maya' => 'Maya (Mock Wallet)',
                                'bank_transfer' => 'Bank Transfer (BDO/BPI Mock)',
                            ])
                            ->required()
                            ->default('gcash')
                            ->native(false),
                        TextInput::make('account_number')
                            ->label('Mobile / Account Number')
                            ->placeholder('e.g. 09171234567')
                            ->required(),
                        TextInput::make('account_name')
                            ->label('Account Holder Name')
                            ->placeholder('e.g. Juan Dela Cruz')
                            ->required(),
                    ])
                    ->action(function (Invoice $record, array $data): void {
                        $dueAmount = $record->amount_due - $record->amount_paid;

                        $record->amount_paid = $record->amount_due;
                        $record->status = 'paid';
                        $record->save();

                        Payment::create([
                            'invoice_id' => $record->id,
                            'amount' => $dueAmount,
                            'payment_date' => now(),
                            'payment_method' => $data['channel'],
                            'transaction_reference' => strtoupper($data['channel']) . '-' . rand(100000, 999999),
                            'status' => 'approved',
                        ]);

                        Notification::make()
                            ->title('Payment Successful!')
                            ->body('Your mock payment of ₱' . number_format($dueAmount, 2) . ' via ' . strtoupper($data['channel']) . ' has been processed.')
                            ->success()
                            ->send();
                    })
                    ->modalHeading('Select Payment Method')
                    ->modalDescription('Please select your preferred checkout channel. This simulates a live GCash/Maya API transaction approval.')
                    ->modalSubmitActionLabel('Confirm Payment'),
            ]);
    }
}
