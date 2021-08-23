<?php

namespace Sourcefli\LaravelRest\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Sourcefli\LaravelRest\LaravelRest
 */
class LaravelRest extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-rest';
    }
}
