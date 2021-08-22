<?php

namespace Sourcefli\LaravelRest\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Sourcefli\LaravelRest\Tests\Models\Comment;
use Sourcefli\LaravelRest\Tests\Models\Post;
use Sourcefli\LaravelRest\Tests\Models\User;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            Post::FK_USER => User::factory(),

            Post::TITLE => $this->faker->sentence(),
            Post::CONTENT => $this->faker->text(),
            Post::SLUG => fn ($a) => Str::slug($a[Post::TITLE]),
        ];
    }

    public function withAllRelations(): self
    {
        $this->afterCreating->push(
            fn (Post $post) => Comment::factory()->create([
                Comment::FK_USER => $post->user->id,
                Comment::FK_POST => $post->id
            ])
        );

        return $this;
    }
}
