<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Post;
use App\Models\Report;
use App\Models\Role;
use App\Models\Thread;
use App\Policies\CommentPolicy;
use App\Policies\CommunityPolicy;
use App\Policies\PostPolicy;
use App\Policies\ReportPolicy;
use App\Policies\RolePolicy;
use App\Policies\ThreadPolicy;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        Community::class => CommunityPolicy::class,
        Comment::class => CommentPolicy::class,
        Thread::class => ThreadPolicy::class,
        Report::class => ReportPolicy::class,
        Role::class => RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        
        Gate::define('admin', function ($user) {
            return $user->roles->where('name', 'Admin')->count() > 0;
        });

        Gate::define('moderator', function ($user) {
            return $user->roles->whereIn('name', ['Admin', 'Moderator'])->count() > 0;
        });
    }
}