<?php

use Sourcefli\LaravelRest\Repositories\ModelRepository;
use Sourcefli\LaravelRest\Repositories\ModelRepositoryContract;

return [
    'repository_contract' => ModelRepositoryContract::class,
    'repository_implementation' => ModelRepository::class,

    'api_only' => false
];
