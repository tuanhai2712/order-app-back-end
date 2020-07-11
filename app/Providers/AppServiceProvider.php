<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\OrderServiceInterface;
use App\Services\OrderService;
use App\Interfaces\UserServiceInterface;
use App\Services\UserService;
use App\Interfaces\SettingServiceInterface;
use App\Services\SettingService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            OrderServiceInterface::class,
            OrderService::class
        );
        $this->app->singleton(
            UserServiceInterface::class,
            UserService::class
        );
        $this->app->singleton(
            SettingServiceInterface::class,
            SettingService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
