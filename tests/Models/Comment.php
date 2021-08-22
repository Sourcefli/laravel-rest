<?php

namespace Sourcefli\LaravelRest\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    const ID = 'id';
    const CONTENT = 'content';
    const FK_USER = 'user_id';
    const FK_POST = 'post_id';
    const TABLE = 'comments';
    const TITLE = 'title';

    protected $table = self::TABLE;

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            self::FK_USER,
            User::ID
        );
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(
            Post::class,
            self::FK_POST,
            Post::ID
        );
    }
}
