<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumFollow extends Model
{
    protected $table = 'album_follows';

    protected $fillable = [
        'user_id',
        'album_id'
    ];
}
