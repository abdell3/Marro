<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ReportPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Report $report)
    {
        
        if ($user->id === $report->user_id) {
            return true;
        }

        
        if ($user->roles->whereIn('name', ['Admin', 'Moderator'])->count() > 0) {
            return true;
        }

        return false;
    }

    public function viewAny(User $user)
    {
        return $user->roles->whereIn('name', ['Admin', 'Moderator'])->count() > 0;
    }

    public function update(User $user, Report $report)
    {
        return $user->roles->whereIn('name', ['Admin', 'Moderator'])->count() > 0;
    }

    public function delete(User $user, Report $report)
    {
        return $user->roles->where('name', 'Admin')->count() > 0;
    }
}
