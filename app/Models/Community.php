<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Community extends Model
{
    use HasFactory;

    protected $fillable = [
        'theme_name',
        'description',
    ];

    /**
     * Get the users that belong to the community.
     */
    public function abonnes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_community');
    }

    /**
     * Get the posts for the community.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the threads for the community.
     */
    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }
}
