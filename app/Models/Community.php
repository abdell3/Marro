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
        'slug',
        'description',
        'user_id',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }


    public function posts()
    {
        return $this->hasMany(Post::class);
    }


}
