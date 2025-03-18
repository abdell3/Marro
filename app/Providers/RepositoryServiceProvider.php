<?php

namespace App\Providers;


use App\Repositories\CommunityRepository;
use App\Repositories\Interfaces\CommunityRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\Interfaces\ThreadRepositoryInterface;
use App\Repositories\TagRepository;
use App\Repositories\ThreadRepository;
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

        $this->app->bind(
            TagRepositoryInterface::class,
            TagRepository::class
        );

        $this->app->bind(
            ThreadRepositoryInterface::class,
            ThreadRepository::class
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
