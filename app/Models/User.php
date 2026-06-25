<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

#[Fillable(['name', 'email', 'password', 'must_reset_password', 'role', 'kyc_status', 'kyc_data'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser, HasTenants
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'must_reset_password' => 'boolean',
            'role' => UserRole::class,
            'kyc_data' => 'array',
        ];
    }

    /**
     * Check if the user is an admin or staff member.
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, [
            UserRole::SuperAdmin,
            UserRole::PropertyManager,
            UserRole::Accountant,
            UserRole::Agent,
        ]);
    }

    /**
     * Check if the user is a client (Owner or Tenant).
     */
    public function isClient(): bool
    {
        return in_array($this->role, [
            UserRole::Owner,
            UserRole::Tenant,
        ]);
    }

    /**
     * Check if the user is a Property Owner.
     */
    public function isOwner(): bool
    {
        return $this->role === UserRole::Owner;
    }

    /**
     * Check if the user is a Tenant.
     */
    public function isTenant(): bool
    {
        return $this->role === UserRole::Tenant;
    }

    /**
     * Determine if the user can access the given panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'platform') {
            return $this->role === UserRole::SuperAdmin;
        }

        if ($panel->getId() === 'admin') {
            return $this->isAdmin();
        }

        if ($panel->getId() === 'portal') {
            return $this->isClient();
        }

        return false;
    }

    /**
     * Get the companies the user belongs to.
     *
     * @return BelongsToMany<Company, $this>
     */
    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_user')->withTimestamps();
    }

    /**
     * Get the tenants the user can access.
     */
    public function getTenants(Panel $panel): Collection
    {
        if ($this->role === UserRole::SuperAdmin) {
            return Company::all();
        }

        return $this->companies()->get();
    }

    /**
     * Determine if the user can access the tenant.
     */
    public function canAccessTenant(Model $tenant): bool
    {
        if ($this->role === UserRole::SuperAdmin) {
            return true;
        }

        return $this->companies()->whereKey($tenant)->exists();
    }
}
