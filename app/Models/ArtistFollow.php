<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistFollow extends Model
{
    protected $table = 'artist_follows';

    protected $fillable = [
        'user_id',
        'artist_id'
    ];
}
