<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $table = 'playlists';

    protected $fillable = [
        'user_id',
        'title',
        'is_public',
        'share_token'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function playlistSongs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PlaylistSong::class);
    }

}
