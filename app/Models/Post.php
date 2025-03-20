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
        'type',
        'file_path',
        'user_id',
        'thread_id',
        'community_id'
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

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
