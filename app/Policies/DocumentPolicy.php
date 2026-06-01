<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\Lease;
use App\Models\UnitOwner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isOwner() || $user->isTenant();
    }

    public function view(User $user, Document $document): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        // Owners/Tenants can view if they uploaded it
        if ($document->uploaded_by === $user->id) {
            return true;
        }

        // If it's a lease document
        if ($document->documentable_type === Lease::class) {
            $lease = $document->documentable;
            if ($lease) {
                if ($user->isTenant()) {
                    return $lease->tenant_id === $user->id;
                }
                if ($user->isOwner()) {
                    return UnitOwner::where('user_id', $user->id)
                        ->where('unit_id', $lease->unit_id)
                        ->exists();
                }
            }
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Document $document): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Document $document): bool
    {
        return $user->isAdmin();
    }
}
