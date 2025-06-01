<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class UserFollow extends Model
{
    use LogsActivity;

    protected $table = 'user_follows';

    protected $fillable = [
        'user_id',
        'following_user_id'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('user_follow')
            ->logOnly(['user_id', 'following_user_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
