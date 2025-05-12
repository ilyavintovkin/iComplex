<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PostService;
use App\Services\FollowService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Регистрируем PostService как singleton (один экземпляр)
        $this->app->singleton(PostService::class, function ($app) {
            return new PostService();
        });

        // Регистрируем FollowService как singleton (один экземпляр)
        $this->app->singleton(FollowService::class, function ($app) {
            return new FollowService();
        });
    }

    public function boot(): void
    {
        
    }
}
