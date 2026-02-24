<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Notification extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'notifications';

    protected $fillable = [
        'user_id',
        'type',
        'data',
        'is_read',
    ];

    protected $casts = [
        'data'    => 'array',
        'is_read' => 'boolean',
    ];

    protected $attributes = [
        'is_read' => false,
        'data'    => [],
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}