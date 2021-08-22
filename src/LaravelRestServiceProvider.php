<?php

namespace Sourcefli\LaravelRest;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Sourcefli\LaravelRest\Commands\LaravelRestCommand;

class LaravelRestServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-rest')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-rest_table')
            ->hasCommand(LaravelRestCommand::class);
    }
}
