<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumSong extends Model
{
    protected $table = 'album_songs';

    protected $fillable = [
        'album_id',
        'song_id',
    ];

    public function song(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Song::class);
    }

    public function album(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
}
