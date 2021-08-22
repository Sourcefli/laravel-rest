<?php

namespace Sourcefli\LaravelRest\Tests;

use Sourcefli\LaravelRest\Tests\Models\Comment;
use Sourcefli\LaravelRest\Tests\Models\Post;
use Sourcefli\LaravelRest\Tests\Models\User;

class ExampleTest extends TestCase
{
    /** @test */
    public function true_is_true()
    {
        dd([
            User::count(), Post::count(), Comment::count()
        ]);
        $this->assertTrue(true);
    }
}
