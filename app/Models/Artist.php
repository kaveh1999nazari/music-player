<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Artist extends Model
{
    protected $table = 'artists';

    protected $fillable = [
        'name',
        'bio',
        'share_token'
    ];

    /**
     * Get the media file (profile image) associated with the artist.
     */
    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'model');
    }

    /**
     * Accessor to get the full URL of the artist's profile image.
     *
     * @return string|null
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->media?->full_url;
    }
}
