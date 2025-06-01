<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PlaylistFollow extends Model
{
    use LogsActivity;

    protected $table = 'playlist_follows';

    protected $fillable = [
        'user_id',
        'playlist_id'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('playlist_follow')
            ->logOnly(['user_id', 'playlist_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
