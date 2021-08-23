<?php

namespace Sourcefli\LaravelRest;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Sourcefli\LaravelRest\Traits\Resourceful;
use Symfony\Component\Finder\SplFileInfo;

class LaravelRest
{
    protected static Closure $loadResourcesUsing;
    protected static Closure $loadApiResourcesUsing;
    protected static array $resources = [];
    protected static array $apiResources = [];
    protected Container $app;

    public function __construct()
    {
        $this->app = Container::getInstance();

        static::$resources = self::$loadResourcesUsing
            ?? value(self::defaultResourceLoader());

        static::$apiResources = self::$loadApiResourcesUsing
            ?? value(static::defaultApiResourceLoader());
    }

    public static function loadResourcesUsing(Closure $closure = null): void
    {
        static::$loadResourcesUsing = $closure;
    }

    public static function loadApiResourcesUsing(Closure $closure = null): void
    {
        static::$loadApiResourcesUsing = $closure;
    }

    private static function defaultResourceLoader(): callable
    {
        return function () {
            return collect(File::allFiles(self::getModelsPath()))
                ->mapWithKeys(function (SplFileInfo $fileInfo) {
                    $model = self::getNamespacedModel($fileInfo->getBasename());

                    return dd(in_array(Resourceful::class, class_uses_recursive($model)));
                });
        };
    }

    private static function defaultApiResourceLoader(): callable
    {
        return function () {
            return collect(File::allFiles(app_path('Models')))
                ->mapWithKeys(function (SplFileInfo $fileInfo) {
                    dd('in resource loader', $fileInfo);
                });
        };
    }

    /**
     * @return string
     */
    private static function getModelsPath(): string
    {
        return app_path(self::modelsDir());
    }

    private static function modelsDir(): string
    {
        return File::isDirectory(app_path('Models'))
            ? 'Models'
            : '';
    }

    private static function getNamespacedModel(string $className)
    {
        $className = Str::endsWith($className, '.php')
            ? (string) Str::of($className)->beforeLast('.php')
            : $className;


        $appRoot = (string) Str::of(app_path())->afterLast('/')->studly()->append('\\');

        return Str::of($className)
                ->when(filled(self::modelsDir()), fn ($str) => $str->prepend('Models\\'))
                ->prepend($appRoot)
                ->tap(function ($str) {
                    dd(app((string) $str));
                    if (! class_exists($model = (string) $str)) {
                        throw new \RuntimeException("No model found at namespace $model");
                    }
                })
                ->__toString();
    }
}
