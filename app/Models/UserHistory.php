<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserHistory extends Model
{
    protected $fillable = [
        'user_id',
        'item_type',
        'item_id',
        'action',
        'duration'
    ];

    public function item(): MorphTo
    {
        return $this->morphTo();
    }
}
