<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */



    use HandlesAuthorization;

    public function update(User $user, Comment $comment)
    {
         
        if ($user->id === $comment->user_id) {
             return true;
        }
 
         
        if ($user->roles->whereIn('name', ['Admin', 'Moderator'])->count() > 0) {
             return true;
        }
 
        return false;
    }
 
    public function delete(User $user, Comment $comment)
    {
         
        if ($user->id === $comment->user_id) {
             return true;
        }
 
        
        if ($user->roles->whereIn('name', ['Admin', 'Moderator'])->count() > 0) {
             return true;
        }
 
        return false;
    }




    // public function viewAny(User $user): bool
    // {
    //     return $user->hasPermission('view-comments');
    // }

    // /**
    //  * Determine whether the user can view the model.
    //  */
    // public function view(User $user, Comment $comment): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can create models.
    //  */
    // public function create(User $user): bool
    // {
    //     return $user->hasPermission('create-comments');
    // }

    // /**
    //  * Determine whether the user can update the model.
    //  */
    // public function update(User $user, Comment $comment): bool
    // {
    //     return $user->hasPermission('edit-posts') || 
    //            ($user->id === $comment->user_id && $user->hasPermission('edit-own-comment'));
    // }

    // /**
    //  * Determine whether the user can delete the model.
    //  */
    // public function delete(User $user, Comment $comment): bool
    // {
    //     return $user->hasPermission('delete-comments') || 
    //            ($user->id === $comment->user_id && $user->hasPermission('delete-own-comments'));
    // }

    // /**
    //  * Determine whether the user can restore the model.
    //  */
    // public function restore(User $user, Comment $comment): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(User $user, Comment $comment): bool
    // {
    //     return false;
    // }
}
