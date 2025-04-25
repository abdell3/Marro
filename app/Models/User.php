<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role_id',
        'badge_id',
        'token',
        'avatar',
        'preferences',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'preferences' => 'array',
    ];
    
    /**
     * Get the role that owns the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
    
    /**
     * Get the badge that owns the user.
     */
    public function badge(): BelongsTo
    {
        return $this->belongsTo(Badge::class);
    }
    
    /**
     * Get the communities that belong to the user.
     */
    public function communities(): BelongsToMany
    {
        return $this->belongsToMany(Community::class, 'user_community');
    }
    
    /**
     * Get the posts for the user.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'auteur_id');
    }
    
    /**
     * Get the comments for the user.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'auteur_id');
    }
    
    /**
     * Get the polls for the user.
     */
    public function polls(): HasMany
    {
        return $this->hasMany(Poll::class, 'utilisateur_id');
    }
    
    /**
     * Get the reports for the user.
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'utilisateur_id');
    }
    
    /**
     * Get the saved posts for the user.
     */
    public function savedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'save_posts');
    }
    
    /**
     * Get the threads for the user.
     */
    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }
    
    /**
     * Check if user has permission
     * 
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $permission): bool
    {
        return $this->role?->permissions()->where('name', $permission)->exists() ?? false;
    }
    
    /**
     * Check if user has role
     * 
     * @param string $roleName
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role?->role_name === $roleName;
    }
}
