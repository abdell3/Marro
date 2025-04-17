<?php

namespace App\Providers;

use App\Repositories\BadgeTypeRepository;
use App\Repositories\BaseRepository;
use App\Repositories\CommentRepository;
use App\Repositories\Interfaces\BadgeRepositoryInterface;
use App\Repositories\Interfaces\CommunityRepositoryInterface;
use App\Repositories\Interfaces\PollRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\ReportRepositoryInterface;
use App\Repositories\Interfaces\ReportTypeRepositoryInterface;
use App\Repositories\Interfaces\SavedPostRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\Interfaces\ThreadRepositoryInterface;
use App\Repositories\CommunityRepository;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\RepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\PermissionRepository;
use App\Repositories\PollRepository;
use App\Repositories\PostRepository;
use App\Repositories\ReportRepository;
use App\Repositories\ReportTypeRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SavedPostRepository;
use App\Repositories\TagRepository;
use App\Repositories\ThreadRepository;
use App\Services\BadgeService;
use App\Services\CommentService;
use App\Services\CommunityService;
use App\Services\PermissionService;
use App\Services\PollService;
use App\Services\PostService;
use App\Services\ReportService;
use App\Services\ReportTypeService;
use App\Services\RoleService;
use App\Services\SavedPostService;
use App\Services\TagService;
use App\Services\ThreadService;
use App\View\Components\GuestLayout;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->app->bind(
            RepositoryInterface::class,
            BaseRepository::class
        );



        
        $this->app->bind(
            BadgeRepositoryInterface::class,
            BadgeTypeRepository::class
        );
        $this->app->bind(BadgeService::class, function ($app){
            return new BadgeService($app->make(BadgeRepositoryInterface::class));
        });
        
        
        $this->app->bind(
            CommentRepositoryInterface::class,
            CommentRepository::class
        );
        $this->app->bind(CommentService::class, function ($app){
            return new CommentService($app->make(CommentRepositoryInterface::class));
        });



        
        $this->app->bind(
            CommunityRepositoryInterface::class,
            CommunityRepository::class
        );
        $this->app->bind(CommunityService::class, function ($app){
            return new CommunityService($app->make(CommunityRepositoryInterface::class));
        });

        
        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionRepository::class
        );
        $this->app->bind(PermissionService::class, function ($app){
            return new PermissionService($app->make(PermissionRepositoryInterface::class));
        });
        



        $this->app->bind(
            PollRepositoryInterface::class,
            PollRepository::class
        );
        $this->app->bind(PollService::class, function ($app){
            return new PollService($app->make(PollRepositoryInterface::class));
        });

        


        $this->app->bind(
            PostRepositoryInterface::class,
            PostRepository::class
        );
        
        $this->app->bind(PostService::class, function ($app) {
            return new PostService($app->make(PostRepositoryInterface::class));
        });
        
        
        
        $this->app->bind(
            ReportRepositoryInterface::class,
            ReportRepository::class
        );
        $this->app->bind(ReportService::class, function ($app){
            return new ReportService($app->make(ReportRepositoryInterface::class));
        });
        
        
        
        $this->app->bind(
            ReportTypeRepositoryInterface::class,
            ReportTypeRepository::class
        );
        $this->app->bind(ReportTypeService::class, function ($app){
            return new ReportTypeService($app->make(ReportTypeRepositoryInterface::class));
        });



        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );
        $this->app->bind(RoleService::class, function ($app){
            return new ReportService($app->make(RoleRepositoryInterface::class));
        });




        $this->app->bind(
            SavedPostRepositoryInterface::class,
            SavedPostRepository::class
        );
        $this->app->bind(SavedPostService::class, function ($app){
            return new SavedPostService($app->make(SavedPostRepositoryInterface::class));
        });




        $this->app->bind(
            TagRepositoryInterface::class,
            TagRepository::class
        );

        $this->app->bind(TagService::class, function ($app){
            return new TagService($app->make(TagRepositoryInterface::class));
        });



        $this->app->bind(
            ThreadRepositoryInterface::class,
            ThreadRepository::class
        );
        $this->app->bind(ThreadService::class, function ($app){
            return new ThreadService($app->make(ThreadRepositoryInterface::class));
        });


        
    }
    
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::component('guest-layout', GuestLayout::class);
    }
}
