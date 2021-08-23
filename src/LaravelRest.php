<?php

namespace Sourcefli\LaravelRest;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Sourcefli\LaravelRest\Traits\ApiResourceful;
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
            return self::collectModels()->filter(
                fn ($m) => in_array(Resourceful::class, class_uses_recursive($m))
            );
        };
    }

    private static function defaultApiResourceLoader(): callable
    {
        return function () {
            return self::collectModels()->filter(
                fn ($m) => in_array(ApiResourceful::class, class_uses_recursive($m)) &&
            );
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

        return (string) Str::of($className)
                ->when(filled(self::modelsDir()),
                    fn ($str) => $str->prepend('Models\\')
                )
                ->prepend($appRoot)
                ->pipe(function (Stringable $str) {
                    return rescue(function () use ($str) {
                        return is_subclass_of((string) $str, Model::class)
                            ? (string) $str
                            : '';
                    },
                        null,
                        false
                    );
                });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private static function collectModels(): \Illuminate\Support\Collection
    {
        return collect(File::allFiles(self::getModelsPath()))
            ->map(function (SplFileInfo $fileInfo) {
                $model = self::getNamespacedModel($fileInfo->getBasename());

                return filled($model) ? $model : null;
            })
            ->filter()
            ->map(fn ($m) => app($m));
    }
}
