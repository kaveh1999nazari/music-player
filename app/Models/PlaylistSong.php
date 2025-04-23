<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaylistSong extends Model
{
    protected $table = 'playlist_songs';

    protected $fillable = [
        'playlist_id',
        'song_id',
        'added_at'
    ];
}
