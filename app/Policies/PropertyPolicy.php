<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Property;
use App\Models\UnitOwner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PropertyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Property $property): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isOwner()) {
            $ownedUnitIds = UnitOwner::where('user_id', $user->id)->pluck('unit_id')->toArray();

            return $property->units()->whereIn('id', $ownedUnitIds)->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::PropertyManager]);
    }

    public function update(User $user, Property $property): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::PropertyManager]);
    }

    public function delete(User $user, Property $property): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::PropertyManager]);
    }
}
