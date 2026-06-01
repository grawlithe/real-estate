<?php

use App\Enums\UserRole;
use App\Filament\Portal\Resources\Remittances\Pages\ListRemittances;
use App\Filament\Portal\Resources\Units\Pages\ListUnits;
use App\Models\Lease;
use App\Models\Property;
use App\Models\Remittance;
use App\Models\Unit;
use App\Models\UnitOwner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('owner can only see their own units and payouts in the portal', function () {
    $ownerA = User::factory()->create(['role' => UserRole::Owner]);
    $ownerB = User::factory()->create(['role' => UserRole::Owner]);

    $tenant1 = User::factory()->create(['role' => UserRole::Tenant, 'name' => 'Juan Dela Cruz']);
    $tenant2 = User::factory()->create(['role' => UserRole::Tenant, 'name' => 'Jose Rizal']);

    $property = Property::create(['name' => 'Ayala Heights', 'address' => 'Makati']);

    // Unit 1 owned by Owner A
    $unit1 = Unit::create([
        'property_id' => $property->id,
        'unit_number' => '101',
        'type' => 'condo',
        'status' => 'occupied',
        'ownership_type' => 'managed',
        'rent_amount' => 50000.00,
        'security_deposit' => 100000.00,
    ]);
    UnitOwner::create([
        'unit_id' => $unit1->id,
        'user_id' => $ownerA->id,
        'share_percentage' => 100.00,
    ]);
    Lease::create([
        'unit_id' => $unit1->id,
        'tenant_id' => $tenant1->id,
        'start_date' => '2026-01-01',
        'end_date' => '2026-12-31',
        'rent_amount' => 50000.00,
        'security_deposit' => 100000.00,
        'status' => 'active',
    ]);

    // Unit 2 owned by Owner B
    $unit2 = Unit::create([
        'property_id' => $property->id,
        'unit_number' => '102',
        'type' => 'condo',
        'status' => 'occupied',
        'ownership_type' => 'managed',
        'rent_amount' => 60000.00,
        'security_deposit' => 120000.00,
    ]);
    UnitOwner::create([
        'unit_id' => $unit2->id,
        'user_id' => $ownerB->id,
        'share_percentage' => 100.00,
    ]);
    Lease::create([
        'unit_id' => $unit2->id,
        'tenant_id' => $tenant2->id,
        'start_date' => '2026-01-01',
        'end_date' => '2026-12-31',
        'rent_amount' => 60000.00,
        'security_deposit' => 120000.00,
        'status' => 'active',
    ]);

    // Remittance for Owner A
    $remitA = Remittance::create([
        'owner_id' => $ownerA->id,
        'unit_id' => $unit1->id,
        'remittance_date' => '2026-06-28',
        'amount' => 45000.00,
        'status' => 'transferred',
    ]);

    // Remittance for Owner B
    $remitB = Remittance::create([
        'owner_id' => $ownerB->id,
        'unit_id' => $unit2->id,
        'remittance_date' => '2026-06-28',
        'amount' => 54000.00,
        'status' => 'transferred',
    ]);

    // Log in as Owner A
    $this->actingAs($ownerA);

    // Verify Units table shows only Unit 1
    Livewire::test(ListUnits::class)
        ->assertCanSeeTableRecords([$unit1])
        ->assertCanNotSeeTableRecords([$unit2]);

    // Verify Remittances table shows only Remittance A
    Livewire::test(ListRemittances::class)
        ->assertCanSeeTableRecords([$remitA])
        ->assertCanNotSeeTableRecords([$remitB]);
});

test('owner cannot view sensitive tenant contact info', function () {
    $owner = User::factory()->create(['role' => UserRole::Owner]);
    $tenant = User::factory()->create([
        'role' => UserRole::Tenant,
        'name' => 'Secret Tenant',
        'email' => 'tenant@private.com',
    ]);

    $property = Property::create(['name' => 'Ayala Heights', 'address' => 'Makati']);
    $unit = Unit::create([
        'property_id' => $property->id,
        'unit_number' => '101',
        'type' => 'condo',
        'status' => 'occupied',
        'ownership_type' => 'managed',
        'rent_amount' => 50000.00,
        'security_deposit' => 100000.00,
    ]);
    UnitOwner::create([
        'unit_id' => $unit->id,
        'user_id' => $owner->id,
        'share_percentage' => 100.00,
    ]);
    Lease::create([
        'unit_id' => $unit->id,
        'tenant_id' => $tenant->id,
        'start_date' => '2026-01-01',
        'end_date' => '2026-12-31',
        'rent_amount' => 50000.00,
        'security_deposit' => 100000.00,
        'status' => 'active',
    ]);

    $this->actingAs($owner);

    // Verify list displays tenant name but does not leak email
    Livewire::test(ListUnits::class)
        ->assertTableColumnStateSet('activeLease.tenant.name', 'Secret Tenant', record: $unit)
        ->assertDontSee('tenant@private.com');
});
