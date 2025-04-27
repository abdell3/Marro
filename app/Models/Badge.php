<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'critere',
        'logo',
    ];

    /**
     * Get the users for the badge.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
