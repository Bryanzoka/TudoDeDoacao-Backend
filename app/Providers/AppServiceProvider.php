<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Interfaces\IUserService;
use App\Services\UserService;   
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            IUserService::class,
            UserService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
