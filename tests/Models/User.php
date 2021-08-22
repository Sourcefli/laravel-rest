<?php

namespace Sourcefli\LaravelRest\Tests\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Authenticatable
        , HasFactory;

    protected $table = 'users';
}
