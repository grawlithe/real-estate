<?php

use App\Enums\UserRole;
use App\Filament\Portal\Resources\Invoices\Pages\ListInvoices;
use App\Models\Invoice;
use App\Models\Lease;
use App\Models\Payment;
use App\Models\Property;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('tenant can pay their invoice through portal table action', function () {
    $tenant = User::factory()->create([
        'role' => UserRole::Tenant,
    ]);

    $property = Property::create([
        'name' => 'Ayala Heights',
        'address' => 'Makati',
    ]);

    $unit = Unit::create([
        'property_id' => $property->id,
        'unit_number' => '101',
        'type' => 'condo',
        'status' => 'occupied',
        'ownership_type' => 'company_owned',
        'rent_amount' => 50000.00,
        'security_deposit' => 100000.00,
    ]);

    $lease = Lease::create([
        'unit_id' => $unit->id,
        'tenant_id' => $tenant->id,
        'start_date' => '2026-01-01',
        'end_date' => '2026-12-31',
        'rent_amount' => 50000.00,
        'security_deposit' => 100000.00,
        'status' => 'active',
    ]);

    $invoice = Invoice::create([
        'lease_id' => $lease->id,
        'tenant_id' => $tenant->id,
        'invoice_number' => 'INV-TEST-101',
        'due_date' => '2026-06-05',
        'amount_due' => 50000.00,
        'amount_paid' => 0.00,
        'status' => 'unpaid',
        'type' => 'rent',
    ]);

    $this->actingAs($tenant);

    Livewire::test(ListInvoices::class)
        ->callTableAction('pay', $invoice, data: [
            'channel' => 'gcash',
            'account_number' => '09171234567',
            'account_name' => 'Juan Dela Cruz',
        ])
        ->assertHasNoTableActionErrors();

    $invoice->refresh();

    expect($invoice->status)->toBe('paid');
    expect($invoice->amount_paid)->toEqual(50000.00);
    expect(Payment::where('invoice_id', $invoice->id)->count())->toBe(1);

    $payment = Payment::where('invoice_id', $invoice->id)->first();
    expect($payment->amount)->toEqual(50000.00);
    expect($payment->payment_method)->toBe('gcash');
    expect($payment->status)->toBe('approved');
});
