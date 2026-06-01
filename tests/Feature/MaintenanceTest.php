<?php

use App\Enums\UserRole;
use App\Filament\Portal\Resources\MaintenanceRequests\Pages\CreateMaintenanceRequest;
use App\Models\Lease;
use App\Models\MaintenanceRequest;
use App\Models\Property;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('tenant can submit a maintenance request', function () {
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

    $this->actingAs($tenant);

    Livewire::test(CreateMaintenanceRequest::class)
        ->fillForm([
            'unit_id' => $unit->id,
            'priority' => 'high',
            'title' => 'Broken hot water shower',
            'description' => 'The water heater in the main bathroom does not heat up.',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(MaintenanceRequest::count())->toBe(1);

    $request = MaintenanceRequest::first();
    expect($request->tenant_id)->toBe($tenant->id);
    expect($request->unit_id)->toBe($unit->id);
    expect($request->priority)->toBe('high');
    expect($request->title)->toBe('Broken hot water shower');
    expect($request->status)->toBe('pending');
});
