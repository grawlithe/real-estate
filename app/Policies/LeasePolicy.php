<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Lease;
use App\Models\UnitOwner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isOwner() || $user->isTenant();
    }

    public function view(User $user, Lease $lease): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isOwner()) {
            return UnitOwner::where('user_id', $user->id)
                ->where('unit_id', $lease->unit_id)
                ->exists();
        }

        if ($user->isTenant()) {
            return $lease->tenant_id === $user->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::PropertyManager]);
    }

    public function update(User $user, Lease $lease): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::PropertyManager]);
    }

    public function delete(User $user, Lease $lease): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::PropertyManager]);
    }
}
