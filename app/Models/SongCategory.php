<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SongCategory extends Model
{
    protected $table = 'song_categories';

    protected $fillable = [
        'song_id',
        'category_id'
    ];

    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
