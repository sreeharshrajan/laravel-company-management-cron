<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurgeLog extends Model
{
    protected $fillable = ['purged_at', 'users_count', 'details'];

    protected $casts = [
        'purged_at' => 'datetime',
        'details' => 'array',
    ];
}
