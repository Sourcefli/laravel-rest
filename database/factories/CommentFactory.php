<?php

namespace Sourcefli\LaravelRest\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Sourcefli\LaravelRest\Tests\Models\Comment;
use Sourcefli\LaravelRest\Tests\Models\Post;
use Sourcefli\LaravelRest\Tests\Models\User;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            Comment::FK_USER => User::factory(),
            Comment::FK_POST => fn ($a) => Post::factory()->state(
                [Post::FK_USER => $a[Comment::FK_USER]]
            ),
            Comment::TITLE => $this->faker->sentence(),
            Comment::CONTENT => $this->faker->text(),
        ];
    }

    public function withAllRelations(): self
    {
//        $this->afterCreating->push();

        return $this;
    }
}
