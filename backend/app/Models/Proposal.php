<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Proposal extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'proposals';

    protected $fillable = [
        'job_id',
        'freelance_id',
        'message',
        'price',
        'status',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function freelance()
    {
        return $this->belongsTo(User::class, 'freelance_id');
    }
}