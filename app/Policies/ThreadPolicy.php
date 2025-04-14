<?php

namespace App\Policies;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ThreadPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    use HandlesAuthorization;

    public function update(User $user, Thread $thread)
    {
        
        if ($user->roles->where('name', 'Admin')->count() > 0) {
            return true;
        }

        
        if ($user->roles->where('name', 'Moderator')->count() > 0 && 
            $user->communities->contains($thread->community_id)) {
            return true;
        }

        return false;
    }

    public function delete(User $user, Thread $thread)
    {
        if ($user->roles->where('name', 'Admin')->count() > 0) {
            return true;
        }

        if ($user->roles->where('name', 'Moderator')->count() > 0 && 
            $user->communities->contains($thread->community_id)) {
            return true;
        }

        return false;
    }
}
