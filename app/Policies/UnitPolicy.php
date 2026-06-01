<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Unit;
use App\Models\UnitOwner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnitPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isOwner();
    }

    public function view(User $user, Unit $unit): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isOwner()) {
            return UnitOwner::where('user_id', $user->id)
                ->where('unit_id', $unit->id)
                ->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::PropertyManager]);
    }

    public function update(User $user, Unit $unit): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::PropertyManager]);
    }

    public function delete(User $user, Unit $unit): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::PropertyManager]);
    }
}
