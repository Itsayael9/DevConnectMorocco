<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'bio',
        'city',
        'skills',
        'github_url',
        'linkedin_url',
        'website_url',
        'followers_count',
        'following_count',
        'is_verified',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'skills' => 'array',
        'is_verified' => 'boolean',
        'followers_count' => 'integer',
        'following_count' => 'integer',
    ];

    protected $attributes = [
        'role' => 'developer',
        'followers_count' => 0,
        'following_count' => 0,
        'is_verified' => false,
    ];
}