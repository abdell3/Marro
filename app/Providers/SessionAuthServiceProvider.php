<?php

namespace App\Providers;

use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SessionAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share auth data with all views
        View::composer('*', function ($view) {
            $authService = app(AuthServiceInterface::class);
            $user = $authService->user();
            
            // Sync Laravel's Auth with our custom auth service
            if ($user && !Auth::check()) {
                Auth::login($user);
            } elseif (!$user && Auth::check()) {
                Auth::logout();
            }
            
            $view->with('authUser', $user);
        });
    }
}
