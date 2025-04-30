<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongArtist extends Model
{
    protected $table = 'song_artists';

    protected $fillable = [
        'artist_id',
        'song_id'
    ];

    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
