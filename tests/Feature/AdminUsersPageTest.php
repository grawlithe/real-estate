<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('super admin can access users index', function () {
    $admin = User::factory()->create([
        'role' => UserRole::SuperAdmin,
    ]);

    User::factory()->count(2)->create();

    $this->actingAs($admin)
        ->get('/platform/users')
        ->assertSuccessful();
});
