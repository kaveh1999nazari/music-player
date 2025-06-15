<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Laravel\Scout\Searchable;

class Album extends Model
{
    use Searchable;

    protected $table = 'albums';

    protected $fillable = [
        'name',
        'artist_id',
        'release_year',
        'share_token'
    ];

    /**
     * Get the artist who created the album.
     */
    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    /**
     * Get the media file (cover image) associated with the album.
     */
    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'model');
    }

    public function songAlbum()
    {
        return $this->hasMany(SongAlbum::class);
    }

    /**
     * Accessor to get the full URL of the cover image.
     *
     * @return string|null
     */
    public function getCoverUrlAttribute(): ?string
    {
        return $this->media?->full_url;
    }

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    public function searchableAs(): string
    {
        return 'albums';
    }

    public function songs(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Song::class, 'song_albums');
    }
}
