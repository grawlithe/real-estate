<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['property_id', 'unit_number', 'type', 'status', 'ownership_type', 'rent_amount', 'security_deposit'])]
class Unit extends Model
{
    use HasFactory;

    /**
     * Get the property that owns the unit.
     *
     * @return BelongsTo<Property, $this>
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the owners of the unit.
     *
     * @return BelongsToMany<User, $this>
     */
    public function owners(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'unit_owners')
            ->withPivot('share_percentage', 'payout_terms')
            ->withTimestamps();
    }

    /**
     * Get the owner relationships directly.
     *
     * @return HasMany<UnitOwner, $this>
     */
    public function unitOwners(): HasMany
    {
        return $this->hasMany(UnitOwner::class);
    }

    /**
     * Get the leases for the unit.
     *
     * @return HasMany<Lease, $this>
     */
    public function leases(): HasMany
    {
        return $this->hasMany(Lease::class);
    }

    /**
     * Get the active lease for the unit.
     *
     * @return HasOne<Lease, $this>
     */
    public function activeLease(): HasOne
    {
        return $this->hasOne(Lease::class)->where('status', 'active');
    }

    /**
     * Get the expenses for the unit.
     *
     * @return HasMany<Expense, $this>
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * Get the maintenance requests for the unit.
     *
     * @return HasMany<MaintenanceRequest, $this>
     */
    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    /**
     * Get the remittances for the unit.
     *
     * @return HasMany<Remittance, $this>
     */
    public function remittances(): HasMany
    {
        return $this->hasMany(Remittance::class);
    }
}
