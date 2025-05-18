<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Song extends Model
{
    protected $table = 'songs';

    protected $fillable = [
        'title',
        'share_token',
        'is_public',
        'created_by',
    ];

    /**
     * Get the category associated with the song.
     */
    public function category(): HasMany
    {
        return $this->hasMany(SongCategory::class);
    }

    public function artist(): HasMany
    {
        return $this->hasMany(SongArtist::class);
    }

    public function artists(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Artist::class, 'song_artists', 'song_id', 'artist_id');
    }

    public function album()
    {
        return $this->hasMany(SongAlbum::class);
    }

    /**
     * Get the media file (audio) associated with the song.
     */
    public function media(): HasMany
    {
        return $this->hasMany(Media::class, 'model_id')->where('model_type', Song::class);
    }

    /**
     * Accessor to get the full URL of the audio file.
     *
     * @return string|null
     */
    public function getAudioUrlAttribute(): ?string
    {
        return $this->media?->full_url;
    }
}
