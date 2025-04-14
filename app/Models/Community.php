<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    /** @use HasFactory<\Database\Factories\CommunityFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'rules',
        'banner',
        'icon',
        'slug',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'community_user');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'community_tag');
    }


}
