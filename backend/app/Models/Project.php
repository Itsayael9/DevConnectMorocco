<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Project extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'projects';

    protected $fillable = [
        'owner_id',
        'title',
        'description',
        'tech_stack',
        'status',
        'members',
        'github_url',
        'demo_url',
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'members'    => 'array',
    ];

    protected $attributes = [
        'status'     => 'open',
        'tech_stack' => [],
        'members'    => [],
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}