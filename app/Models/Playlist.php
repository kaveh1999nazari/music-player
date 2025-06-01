<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Playlist extends Model
{
    use LogsActivity;

    protected $table = 'playlists';

    protected $fillable = [
        'user_id',
        'title',
        'is_public',
        'share_token'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function playlistSongs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PlaylistSong::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('playlist')
            ->logOnly(['user_id', 'title', 'is_public', 'share_token'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
