<?php

namespace Sourcefli\LaravelRest\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Sourcefli\LaravelRest\Tests\Models\Comment;
use Sourcefli\LaravelRest\Tests\Models\Post;
use Sourcefli\LaravelRest\Tests\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            User::EMAIL => $this->faker->email(),
            User::USERNAME => $this->faker->userName(),
        ];
    }

    public function withAllRelations(): self
    {
        $this->afterCreating->push(
            fn (User $user) => Comment::factory()
                ->for(
                    Post::factory()->state([Post::FK_USER => $user->id])
                )
                ->create([
                    Comment::FK_USER => $user->id
                ])
        );

        return $this;
    }
}
