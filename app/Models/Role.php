<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Permission;


class Role extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;


    protected $fillable = [
        'name',
        'description'
    ];

    
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }



    
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }
}
