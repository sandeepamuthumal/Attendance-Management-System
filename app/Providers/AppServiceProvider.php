<?php

namespace App\Providers;

use App\Repositories\ClassRepository;
use App\Repositories\Contracts\ClassRepositoryInterface;
use App\Repositories\Contracts\StudentClassRepositoryInterface;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\Contracts\TeacherRepositoryInterface;
use App\Repositories\StudentClassRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherRepository;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TeacherRepositoryInterface::class, TeacherRepository::class);
        $this->app->bind(ClassRepositoryInterface::class, ClassRepository::class);
        // Student Management Repository Bindings
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(StudentClassRepositoryInterface::class, StudentClassRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
