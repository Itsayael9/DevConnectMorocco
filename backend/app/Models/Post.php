<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Post extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'posts';

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'content',
        'tags',
        'media',
        'likes_count',
        'comments_count',
        'views_count',
        'is_pinned',
    ];

    protected $casts = [
        'tags'           => 'array',
        'media'          => 'array',
        'is_pinned'      => 'boolean',
        'likes_count'    => 'integer',
        'comments_count' => 'integer',
        'views_count'    => 'integer',
    ];

    protected $attributes = [
        'likes_count'    => 0,
        'comments_count' => 0,
        'views_count'    => 0,
        'is_pinned'      => false,
        'tags'           => [],
        'media'          => [],
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }
}