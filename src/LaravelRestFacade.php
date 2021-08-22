<?php

namespace Sourcefli\LaravelRest;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Sourcefli\LaravelRest\LaravelRest
 */
class LaravelRestFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-rest';
    }
}
