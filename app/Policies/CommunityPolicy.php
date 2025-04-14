<?php

namespace App\Policies;

use App\Models\Community;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CommunityPolicy
{
    /**
     * Determine whether the user can view any models.
     */



    use HandlesAuthorization;

    public function update(User $user, Community $community)
    {
        
        if ($user->roles->where('name', 'Admin')->count() > 0) {
             return true;
        }
 
         
        if ($user->roles->where('name', 'Moderator')->count() > 0 && $community->users->contains($user->id)) {
             return true;
        }
 
        return false;
    }
 
    public function delete(User $user, Community $community)
    {  
        return $user->roles->where('name', 'Admin')->count() > 0;
    }

    // public function viewAny(User $user): bool
    // {
    //     return $user->hasPermission('view-communities');
    // }

    // /**
    //  * Determine whether the user can view the model.
    //  */
    // public function view(User $user, Community $community): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can create models.
    //  */
    // public function create(User $user): bool
    // {
    //     return $user->hasPermission('create-communities');
    // }

    // /**
    //  * Determine whether the user can update the model.
    //  */
    // public function update(User $user, Community $community): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can delete the model.
    //  */
    // public function delete(User $user, Community $community): bool
    // {
    //     return $user->hasPermission('delete-communities') || 
    //            ($user->id === $community->creator_id && $user->hasPermission('delete-own-communities'));
    // }

    // /**
    //  * Determine whether the user can restore the model.
    //  */
    // public function restore(User $user, Community $community): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(User $user, Community $community): bool
    // {
    //     return false;
    // }




}
