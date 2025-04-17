<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function getAllUsers()
    {
        return User::with('roles')->paginate(15);
    }

    public function getUserById($id)
    {
        return User::with([
                'roles', 
                'badges', 
                'posts', 
                'comments', 
                'communities'
            ])->findOrFail($id);
    }


    public function getUsersWithRole($roleName)
    {
        return User::whereHas('roles', function($query) use ($roleName) {
            $query->where('name', $roleName);
        })->get();
    }


    public function getUsersWithBadge($badgeId)
    {
        return User::whereHas('badges', function($query) use ($badgeId) {
            $query->where('badge_id', $badgeId);
        })->get();
    }


    public function createUser(array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        
        return User::create($data);
    }

    public function updateUser($id, array $data)
    {
        $user = User::findOrFail($id);
        
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        
        if (isset($data['avatar']) && $data['avatar'] instanceof \Illuminate\Http\UploadedFile) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $data['avatar'] = $data['avatar']->store('avatars', 'public');
        }
        
        $user->update($data);
        
        return $user;
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        
        return $user->delete();
    }

    public function assignRole($userId, $roleId)
    {
        $user = User::findOrFail($userId);
        $user->roles()->syncWithoutDetaching([$roleId]);
        return $user;
    }

    public function removeRole($userId, $roleId)
    {
        $user = User::findOrFail($userId);
        $user->roles()->detach($roleId);
        return $user;
    }

    public function syncRoles($userId, array $roleIds)
    {
        $user = User::findOrFail($userId);
        $user->roles()->sync($roleIds);
        return $user;
    }

    public function awardBadge($userId, $badgeId)
    {
        $user = User::findOrFail($userId);
        if (!$user->badges()->where('badge_id', $badgeId)->exists()) {
            $user->badges()->attach($badgeId);
        }
        return $user;
    }

    public function revokeBadge($userId, $badgeId)
    {
        $user = User::findOrFail($userId);
        $user->badges()->detach($badgeId);
        return $user;
    }
}
