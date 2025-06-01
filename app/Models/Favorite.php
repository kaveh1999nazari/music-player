<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Favorite extends Model
{
    use LogsActivity;

    protected $table = 'favorites';

    protected $fillable = [
        'user_id',
        'song_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('favorite')
            ->logOnly(['user_id', 'song_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
