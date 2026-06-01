<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Remittance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RemittancePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isOwner();
    }

    public function view(User $user, Remittance $remittance): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isOwner()) {
            return $remittance->owner_id === $user->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Accountant]);
    }

    public function update(User $user, Remittance $remittance): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Accountant]);
    }

    public function delete(User $user, Remittance $remittance): bool
    {
        return $user->role === UserRole::SuperAdmin;
    }
}
