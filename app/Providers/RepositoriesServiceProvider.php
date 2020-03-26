<?php

namespace App\Providers;

use App\Http\Repositories\ProjectRepository;
use App\Http\Repositories\TaskRepository;
use App\Http\RepositoryInterfaces\ProjectRepositoryInterface;
use App\Http\RepositoryInterfaces\TaskRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
//        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }
}
