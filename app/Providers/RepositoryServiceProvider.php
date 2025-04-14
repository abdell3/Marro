<?php

namespace App\Providers;

use App\Repositories\BaseRepository;
use App\Repositories\CommentRepository;
use App\Repositories\Interfaces\CommunityRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\Interfaces\ThreadRepositoryInterface;
use App\Repositories\CommunityRepository;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\RepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\PermissionRepository;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use App\Repositories\ThreadRepository;
use App\Services\CommentService;
use App\Services\CommunityService;
use App\Services\PermissionService;
use App\Services\PostService;
use App\Services\TagService;
use App\Services\ThreadService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            CommunityRepositoryInterface::class,
            CommunityRepository::class
        );
        $this->app->bind(CommunityService::class, function ($app){
            return new CommunityService($app->make(CommunityRepositoryInterface::class));
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



        
        $this->app->bind(
            PostRepositoryInterface::class,
            PostRepository::class
        );
        
        $this->app->bind(PostService::class, function ($app) {
            return new PostService($app->make(PostRepositoryInterface::class));
        });


        

        $this->app->bind(
            CommentRepositoryInterface::class,
            CommentRepository::class
        );
        $this->app->bind(CommentService::class, function ($app){
            return new CommentService($app->make(CommentRepositoryInterface::class));
        });



        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionRepository::class
        );
        $this->app->bind(PermissionService::class, function ($app){
            return new PermissionService($app->make(PermissionRepositoryInterface::class), $app->make(PermissionRepositoryInterface::class));
        });


        $this->app->bind(
            RepositoryInterface::class,
            BaseRepository::class
        );





    }
    
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
