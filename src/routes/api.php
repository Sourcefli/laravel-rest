<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::get('foo', fn () => 'api_bar');
//    \Sourcefli\LaravelRest\LaravelRest::loadRoutes();
});
