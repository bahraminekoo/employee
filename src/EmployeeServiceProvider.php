<?php

namespace Bahraminekoo\Employee;

use Illuminate\Support\ServiceProvider;
use Bahraminekoo\Employee\Repositories\EmployeeRepository;
use Bahraminekoo\Employee\Repositories\Interfaces\EmployeeRepositoryInterface;

class EmployeeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            EmployeeRepositoryInterface::class,
            EmployeeRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');

        $this->publishMigrations();

        $this->publishFactories();

        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'paloit');

        $this->loadViewsFrom(__DIR__.'/resources/views', 'paloit');

        $this->publishes([
            __DIR__.'/resources/css' => public_path('css'),
        ], 'public');

        $this->publishes([
            __DIR__.'/resources/js' => public_path('js'),
        ], 'public');

        $this->publishes([
            __DIR__.'/config/employee.php' => config_path('employee.php'),
        ], 'config');
    }

    private function publishMigrations()
    {
        $path = $this->getMigrationsPath();
        $this->publishes([$path => database_path('migrations')], 'migrations');
    }

    private function getMigrationsPath()
    {
        return __DIR__ . '/database/migrations/';
    }

    private function publishFactories()
    {
        $path = $this->getFactoriesPath();
        $this->publishes([$path => database_path('factories')], 'factories');
    }

    private function getFactoriesPath()
    {
        return __DIR__ . '/database/factories/';
    }
}
