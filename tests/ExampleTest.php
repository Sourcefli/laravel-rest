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
//        $u = User::factory()->create();
//        $p = Post::factory()->for($u)->create();
//        $c = Comment::factory()->for($u)->for($p)->count(4)->create();

        Comment::factory()->withAllRelations()->create();
//        Post::factory()->withAllRelations()->create();
//        Comment::factory()->withAllRelations()->create();
        dd([
            User::get(),
            Post::get(),
            Comment::get()
        ]);
//        $this->assertTrue(true);
    }
}
