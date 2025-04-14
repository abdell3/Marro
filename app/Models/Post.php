<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'community_id',
        'upvotes',
        'downvotes',
        'is_pinned',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }   

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function savedBy()
    {
        return $this->hasMany(SavedPost::class);
    }


    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function poll()
    {
        return $this->hasOne(Poll::class);
    }

}
