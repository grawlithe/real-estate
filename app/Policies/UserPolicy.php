<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return in_array($user->role, [
            UserRole::SuperAdmin,
            UserRole::Owner,
            UserRole::PropertyManager,
        ], true);
    }

    public function view(User $user, User $model): bool
    {
        return in_array($user->role, [
            UserRole::SuperAdmin,
            UserRole::Owner,
            UserRole::PropertyManager,
        ], true) || $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [
            UserRole::SuperAdmin,
            UserRole::Owner,
            UserRole::PropertyManager,
        ], true);
    }

    public function update(User $user, User $model): bool
    {
        return $user->role === UserRole::SuperAdmin || $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->role === UserRole::SuperAdmin && $user->id !== $model->id;
    }
}
