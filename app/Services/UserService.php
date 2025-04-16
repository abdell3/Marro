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
        return User::paginate(15);
    }

    public function getUserById($id)
    {
        return User::findOrFail($id);
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
}
