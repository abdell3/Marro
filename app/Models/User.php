<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\Permission;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'bio',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function permissions()
    {
        return $this->roles()->with('permissions')->get()
        ->pluck('permissions')
        ->flatten()
        ->unique('id');
    }

    // public function hasRole($role)
    // {
    //     return $this->roles()->where('user_id', $role)->exists();
    // }



    // // public function hasPermission($permission)
    // {
    //     return $this->permissions()->where('name', $permission)->isNotEmpty();
    // }



    public function profile()
    {
        if($this->hasRole('user'))
        {
            return $this->user;
        }
        elseif($this->hasRole('admin'))
        {
            return $this->admin;
        }


        return null;
    }


    public function communities()
    {
        return $this->belongsToMany(Community::class, 'community_user');
    }


    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function savedPosts()
    {
        return $this->hasMany(SavedPost::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }


    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'badge_user');
    }


}
