<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\MaintenanceRequest;
use App\Models\UnitOwner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaintenanceRequestPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isOwner() || $user->isTenant();
    }

    public function view(User $user, MaintenanceRequest $request): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isOwner()) {
            return UnitOwner::where('user_id', $user->id)
                ->where('unit_id', $request->unit_id)
                ->exists();
        }

        if ($user->isTenant()) {
            return $request->tenant_id === $user->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isTenant();
    }

    public function update(User $user, MaintenanceRequest $request): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, MaintenanceRequest $request): bool
    {
        return $user->role === UserRole::SuperAdmin;
    }
}
