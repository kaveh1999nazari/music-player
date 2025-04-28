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
        'artist_id',
        'album_id',
        'category_id',
        'share_token',
        'is_public',
        'created_by',
    ];

    /**
     * Get the category associated with the song.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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
