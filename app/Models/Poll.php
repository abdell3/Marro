<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = [
        'utilisateur_id',
        'post_id',
        'typeVote',
    ];

    /**
     * Get the user that owns the poll.
     */
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    /**
     * Get the post that owns the poll.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
