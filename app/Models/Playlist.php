<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Laravel\Scout\Searchable;

class Playlist extends Model
{
    use Searchable;

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

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
        ];
    }

    public function searchableAs(): string
    {
        return 'playlists';
    }

    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'model');
    }
}
