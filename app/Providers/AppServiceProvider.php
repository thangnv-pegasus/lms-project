<?php

namespace App\Providers;

use App\Services\AcademicYear\AcademicYearService;
use App\Services\AcademicYear\AcademicYearServiceInterface;
use App\Services\Auth\AuthInterface;
use App\Services\Auth\AuthService;
use App\Services\Course\CourseService;
use App\Services\Course\CourseServiceInterface;
use App\Services\Exercise\ExcerciseService;
use App\Services\Exercise\ExerciseServiceInterface;
use App\Services\Lesson\LessonService;
use App\Services\Lesson\LessonServiceInterface;
use App\Services\Task\TaskService;
use App\Services\Task\TaskServiceInterface;
use App\Services\User\UserService;
use App\Services\User\UserServiceInterface;
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
        $this->app->bind(LessonServiceInterface::class, LessonService::class);
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(ExerciseServiceInterface::class, ExcerciseService::class);
        $this->app->bind(AcademicYearServiceInterface::class, AcademicYearService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
