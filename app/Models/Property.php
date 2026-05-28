<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'address', 'description'])]
class Property extends Model
{
    use HasFactory;

    /**
     * Get the units for the property.
     *
     * @return HasMany<Unit, $this>
     */
    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }
}
