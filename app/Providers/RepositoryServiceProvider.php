<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\BadgeRepositoryInterface;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\CommunityRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\PollRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\ReportRepositoryInterface;
use App\Repositories\Interfaces\ReportTypeRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\SavePostRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\Interfaces\ThreadRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\BadgeRepository;
use App\Repositories\BaseRepository;
use App\Repositories\CommentRepository;
use App\Repositories\CommunityRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\PollRepository;
use App\Repositories\PostRepository;
use App\Repositories\ReportRepository;
use App\Repositories\ReportTypeRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SavePostRepository;
use App\Repositories\TagRepository;
use App\Repositories\ThreadRepository;
use App\Repositories\UserRepository;
use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Interfaces\BadgeServiceInterface;
use App\Services\Interfaces\CommentServiceInterface;
use App\Services\Interfaces\CommunityServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\ReportServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\AuthService;
use App\Services\BadgeService;
use App\Services\CommentService;
use App\Services\CommunityService;
use App\Services\PostService;
use App\Services\ReportService;
use App\Services\UserService;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind repositories
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(BadgeRepositoryInterface::class, BadgeRepository::class);
        $this->app->bind(CommunityRepositoryInterface::class, CommunityRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(PollRepositoryInterface::class, PollRepository::class);
        $this->app->bind(ReportRepositoryInterface::class, ReportRepository::class);
        $this->app->bind(ReportTypeRepositoryInterface::class, ReportTypeRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(ThreadRepositoryInterface::class, ThreadRepository::class);
        $this->app->bind(SavePostRepositoryInterface::class, SavePostRepository::class);
        
        // Bind services
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(PostServiceInterface::class, PostService::class);
        $this->app->bind(CommentServiceInterface::class, CommentService::class);
        $this->app->bind(CommunityServiceInterface::class, CommunityService::class);
        $this->app->bind(ReportServiceInterface::class, ReportService::class);
        $this->app->bind(BadgeServiceInterface::class, BadgeService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
