<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Job extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'jobs';

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'budget',
        'skills',
        'deadline',
        'status',
        'proposals_count',
    ];

    protected $casts = [
        'skills'          => 'array',
        'budget'          => 'float',
        'proposals_count' => 'integer',
        'deadline'        => 'datetime',
    ];

    protected $attributes = [
        'status'          => 'open',
        'skills'          => [],
        'proposals_count' => 0,
    ];

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class, 'job_id');
    }
}