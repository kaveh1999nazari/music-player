<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AlbumFollow extends Model
{
    use LogsActivity;

    protected $table = 'album_follows';

    protected $fillable = [
        'user_id',
        'album_id'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('album_follow')
            ->logOnly(['user_id', 'album_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
