<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Invoice;
use App\Models\UnitOwner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isOwner() || $user->isTenant();
    }

    public function view(User $user, Invoice $invoice): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isOwner()) {
            return UnitOwner::where('user_id', $user->id)
                ->where('unit_id', $invoice->lease?->unit_id)
                ->exists();
        }

        if ($user->isTenant()) {
            return $invoice->tenant_id === $user->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Accountant, UserRole::PropertyManager]);
    }

    public function update(User $user, Invoice $invoice): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Accountant, UserRole::PropertyManager]);
    }

    public function delete(User $user, Invoice $invoice): bool
    {
        return $user->role === UserRole::SuperAdmin;
    }
}
