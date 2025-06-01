<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SongArtist extends Model
{
    use LogsActivity;

    protected $table = 'song_artists';

    protected $fillable = [
        'artist_id',
        'song_id'
    ];

    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('song_artist')
            ->logOnly(['artist_id', 'song_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
