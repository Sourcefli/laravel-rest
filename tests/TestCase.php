<?php

namespace Sourcefli\LaravelRest\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;
use Sourcefli\LaravelRest\LaravelRestServiceProvider;
use Sourcefli\LaravelRest\Tests\Models\Comment;
use Sourcefli\LaravelRest\Tests\Models\Post;
use Sourcefli\LaravelRest\Tests\Models\User;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Sourcefli\\LaravelRest\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelRestServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $app['db']->connection()->getSchemaBuilder()->create(User::TABLE, function (Blueprint $table) {
            $table->increments(User::ID);
            $table->string(User::EMAIL);
            $table->string(User::USERNAME);
            $table->timestamps();
        });

        $app['db']->connection()->getSchemaBuilder()->create(Post::TABLE, function (Blueprint $table) {
            $table->increments(Post::ID);
            $table->string(Post::TITLE);
            $table->string(Post::SLUG)->unique();
            $table->text(Post::CONTENT);
            $table->foreignId(Post::FK_USER)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        $app['db']->connection()->getSchemaBuilder()->create(Comment::TABLE, function (Blueprint $table) {
            $table->increments(Comment::ID);
            $table->string(Comment::TITLE);
            $table->text(Comment::CONTENT);
            $table->foreignId(Comment::FK_USER)->constrained();
            $table->foreignId(Comment::FK_POST)->constrained();
            $table->timestamps();
        });
    }
}
