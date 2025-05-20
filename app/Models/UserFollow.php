<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    protected $table = 'user_follows';

    protected $fillable = [
        'user_id',
        'following_user_id'
    ];
}
