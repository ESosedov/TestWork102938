<?php

namespace App\Providers;

use App\Http\Controllers\Api\V1\CompanyController;
use App\Http\Controllers\Api\V1\EmployeeController;
use App\Repositories\CompanyRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\Interfaces\Repository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->bind(
//            Repository::class,
//            EmployeeRepository::class
//        );
        $this->app->when(EmployeeController::class)
            ->needs(Repository::class,)
            ->give(EmployeeRepository::class);

        $this->app->when(CompanyController::class)
            ->needs(Repository::class,)
            ->give(CompanyRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
