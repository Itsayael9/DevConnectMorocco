<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Skill extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'skills_stats';

    protected $fillable = [
        'skill_name',
        'category',
        'usage_count',
        'region',
        'year',
    ];

    protected $casts = [
        'usage_count' => 'integer',
        'year'        => 'integer',
    ];

    protected $attributes = [
        'usage_count' => 0,
        'region'      => 'Morocco',
    ];
}