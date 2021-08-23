<?php

namespace Sourcefli\LaravelRest;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Sourcefli\LaravelRest\Commands\LaravelRestCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelRestServiceProvider extends PackageServiceProvider
{

    public function register()
    {
        $this->app->bind(config('laravel-rest.repository_contract'), function (Application $app) {
            return new config('laravel-rest.repository_implementation');
        });
    }

    public function boot()
    {
        Model::unguard();
    }

    public function packageBooted()
    {
        if ($this->app->environment('testing')) {
            $this->loadRoutesFrom(__DIR__.'../tests/Http/routes.php');
        }
    }

    public function configurePackage(Package $package): void
    {
        /*
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-rest')
            ->hasConfigFile('laravel-rest')
            ->hasCommand(LaravelRestCommand::class);
    }
}
