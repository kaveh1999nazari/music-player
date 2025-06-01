<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SongCategory extends Model
{
    use LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('song_category')
            ->logOnly(['song_id', 'category_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
