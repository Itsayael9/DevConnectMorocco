<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Like extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'likes';

    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
