<?php

namespace App\Providers;

use App\Services\Auth\AuthInterface;
use App\Services\Auth\AuthService;
use App\Services\Course\CourseService;
use App\Services\Course\CourseServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthInterface::class, AuthService::class);
        $this->app->bind(CourseServiceInterface::class, CourseService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
