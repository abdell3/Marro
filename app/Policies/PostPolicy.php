<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */

    use HandlesAuthorization;
    // protected $permissionService;

    // public function __construct(PermissionService $permissionService)
    // {
    //      $this->permissionService = $permissionService;
    // }




    public function update(User $user, Post $post)
     {
         
        if ($user->id === $post->user_id) {
             return true;
        }
 
        
        if ($user->roles->whereIn('name', ['Admin', 'Moderator'])->count() > 0) {
             return true;
        }
 
        return false;
    }
 
    public function delete(User $user, Post $post)
     {
        
        if ($user->id === $post->user_id) {
             return true;
         }
 
        
        if ($user->roles->whereIn('name', ['Admin', 'Moderator'])->count() > 0) {
             return true;
         }
 
        return false;
    }





    // public function viewAny(User $user): bool
    // {
    //     return $user->hasPermission('view-posts');
    // }

    // /**
    //  * Determine whether the user can view the model.
    //  */
    // public function view(User $user, Post $post): bool
    // {
    //     return $user->hasPermission('view-posts');
    // }

    // /**
    //  * Determine whether the user can create models.
    //  */
    // public function create(User $user): bool
    // {
    //     return $user->hasPermission('create-posts');
    // }

    // /**
    //  * Determine whether the user can update the model.
    //  */
    // public function update(User $user, Post $post): bool
    // {
    //     return $user->hasPermission('edit-posts') || 
    //            ($user->id === $post->user_id && $user->hasPermission('edit-own-posts'));
    // }

    // /**
    //  * Determine whether the user can delete the model.
    //  */
    // public function delete(User $user, Post $post): bool
    // {
    //     return $user->hasPermission('delete-posts') || 
    //            ($user->id === $post->user_id && $user->hasPermission('delete-own-posts'));
    // }
    

    // /**
    //  * Determine whether the user can restore the model.
    //  */
    // public function restore(User $user, Post $post): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(User $user, Post $post): bool
    // {
    //     return false;
    // }
}
