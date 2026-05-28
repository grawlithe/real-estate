<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'kyc_status', 'kyc_data'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
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
        if ($panel->getId() === 'admin') {
            return $this->isAdmin();
        }

        if ($panel->getId() === 'portal') {
            return $this->isClient();
        }

        return false;
    }
}
