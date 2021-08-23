<?php

namespace Sourcefli\LaravelRest\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
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

    /**
     * Override application aliases.
     *
     * @param  Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app): array
    {
        return [
            'LaravelRest' => 'Sourcefli\\LaravelRest\\Facades\\LaravelRest',
        ];
    }

    /**
     * Ignore package discovery from.
     *
     * @return array
     */
    public function ignorePackageDiscoveriesFrom()
    {
        return [];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->app['db']->connection()->getSchemaBuilder()->create(User::TABLE, function (Blueprint $table) {
            $table->increments(User::ID);
            $table->string(User::EMAIL);
            $table->string(User::USERNAME);
            $table->timestamps();
        });

        $this->app['db']->connection()->getSchemaBuilder()->create(Post::TABLE, function (Blueprint $table) {
            $table->increments(Post::ID);
            $table->string(Post::TITLE);
            $table->string(Post::SLUG)->unique();
            $table->text(Post::CONTENT);
            $table->foreignId(Post::FK_USER)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        $this->app['db']->connection()->getSchemaBuilder()->create(Comment::TABLE, function (Blueprint $table) {
            $table->increments(Comment::ID);
            $table->string(Comment::TITLE);
            $table->text(Comment::CONTENT);
            $table->foreignId(Comment::FK_USER)->constrained();
            $table->foreignId(Comment::FK_POST)->constrained();
            $table->timestamps();
        });

    }
}
