<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SongAlbum extends Model
{
    use LogsActivity;

    protected $table = 'song_albums';

    protected $fillable = [
        'album_id',
        'song_id'
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('song_album')
            ->logOnly(['album_id', 'song_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
