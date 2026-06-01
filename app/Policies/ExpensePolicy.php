<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Expense;
use App\Models\UnitOwner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpensePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isOwner();
    }

    public function view(User $user, Expense $expense): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isOwner()) {
            return UnitOwner::where('user_id', $user->id)
                ->where('unit_id', $expense->unit_id)
                ->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Accountant, UserRole::PropertyManager]);
    }

    public function update(User $user, Expense $expense): bool
    {
        return in_array($user->role, [UserRole::SuperAdmin, UserRole::Accountant, UserRole::PropertyManager]);
    }

    public function delete(User $user, Expense $expense): bool
    {
        return $user->role === UserRole::SuperAdmin;
    }
}
