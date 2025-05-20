<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaylistFollow extends Model
{
    protected $table = 'playlist_follows';

    protected $fillable = [
        'user_id',
        'playlist_id'
    ];
}
