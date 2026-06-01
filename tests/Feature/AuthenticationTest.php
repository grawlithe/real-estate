<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest is redirected to admin login', function () {
    $this->get('/admin')
        ->assertRedirect('/admin/login');
});

test('guest is redirected to portal login', function () {
    $this->get('/portal')
        ->assertRedirect('/portal/login');
});

test('tenant cannot access admin panel', function () {
    $tenant = User::factory()->create([
        'role' => UserRole::Tenant,
    ]);

    $this->actingAs($tenant)
        ->get('/admin')
        ->assertForbidden();
});

test('owner cannot access admin panel', function () {
    $owner = User::factory()->create([
        'role' => UserRole::Owner,
    ]);

    $this->actingAs($owner)
        ->get('/admin')
        ->assertForbidden();
});

test('super admin cannot access portal panel', function () {
    $admin = User::factory()->create([
        'role' => UserRole::SuperAdmin,
    ]);

    $this->actingAs($admin)
        ->get('/portal')
        ->assertForbidden();
});

test('super admin can access admin panel', function () {
    $admin = User::factory()->create([
        'role' => UserRole::SuperAdmin,
    ]);

    $this->actingAs($admin)
        ->get('/admin')
        ->assertSuccessful();
});

test('tenant can access portal panel', function () {
    $tenant = User::factory()->create([
        'role' => UserRole::Tenant,
    ]);

    $this->actingAs($tenant)
        ->get('/portal')
        ->assertSuccessful();
});

test('owner can access portal panel', function () {
    $owner = User::factory()->create([
        'role' => UserRole::Owner,
    ]);

    $this->actingAs($owner)
        ->get('/portal')
        ->assertSuccessful();
});
