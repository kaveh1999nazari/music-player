<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PlaylistSong extends Model
{
    use LogsActivity;

    protected $table = 'playlist_songs';

    protected $fillable = [
        'playlist_id',
        'song_id',
        'added_at'
    ];

    public $timestamps = false;

    public function song(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Song::class)->with('media');
    }

    public function playlist(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Playlist::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('playlist_song')
            ->logOnly(['playlist_id', 'song_id', 'added_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
