<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ArtistFollow extends Model
{
    use LogsActivity;

    protected $table = 'artist_follows';

    protected $fillable = [
        'user_id',
        'artist_id'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('artist_follow')
            ->logOnly(['user_id', 'artist_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
