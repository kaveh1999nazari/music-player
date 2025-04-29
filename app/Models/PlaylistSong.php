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

    public $timestamps = false;

    public function song(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Song::class)->with('media');
    }

    public function playlist(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Playlist::class);
    }
}
