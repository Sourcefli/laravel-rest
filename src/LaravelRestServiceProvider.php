<?php

namespace Sourcefli\LaravelRest;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Sourcefli\LaravelRest\Commands\LaravelRestCommand;
use Sourcefli\LaravelRest\Tests\TestCase;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelRestServiceProvider extends PackageServiceProvider
{
    private static array $cached = [];

    public function register()
    {
        $this->app->bind(config('laravel-rest.repository_contract'), function (Application $app) {
            return new config('laravel-rest.repository_implementation');
        });
    }

    public function boot()
    {

        if ($this->inPackageDevelopment()) {
            Model::unguard();

            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
            $this->loadRoutesFrom(__DIR__.'/routes/api.php');

            $this->createModelFromStub('User');
            $this->createModelFromStub('Post');
            $this->createModelFromStub('Comment');
        }

        $this->app->singleton('laravel-rest', fn () => new LaravelRest);

        $f = \Sourcefli\LaravelRest\Facades\LaravelRest::getFacadeRoot();

//        LaravelRest::loadResources();
//        LaravelRest::loadApiResources();
    }

    public function bootingPackage()
    {
//        dd(File::exists(app_path('Models/User.php')));
    }

    public function packageBooted()
    {

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

    /**
     * @return bool
     */
    private function inPackageDevelopment(): bool
    {
        return $this->app->environment('testing') &&
               config('database.default') === 'testbench';
    }

    private function getStubsDirectory(): string
    {
        return $this->getTestDirectory().'/stubs';
    }

    private function getTestDirectory(): string
    {
        return data_get(static::$cached, 'test_dir', function () {
            $class = new \ReflectionClass(TestCase::class);

            return static::$cached['test_dir'] = dirname($class->getFileName());
        });
    }

    private function createModelFromStub(string $className): void
    {
        $className = Str::studly($className);

        if (File::exists(app_path('Models'))) {
            File::copy($this->getStubsDirectory() . "/{$className}.php.stub", app_path("Models/{$className}.php"));
        }
    }
}
