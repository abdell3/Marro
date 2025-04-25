<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'contenu',
        'typeContenu',
        'media_path',
        'media_type',
        'datePublication',
        'auteur_id',
        'community_id',
        'like',
    ];

    protected $casts = [
        'datePublication' => 'datetime',
    ];

    /**
     * Get the user that owns the post.
     */
    public function auteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auteur_id');
    }

    /**
     * Get the community that owns the post.
     */
    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    /**
     * Get the comments for the post.
     */
    public function commentaires(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the polls for the post.
     */
    public function polls(): HasMany
    {
        return $this->hasMany(Poll::class);
    }

    /**
     * Get the users that saved the post.
     */
    public function savedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'save_posts');
    }

    /**
     * Get the tags for the post.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get all of the post's reports.
     */
    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}
