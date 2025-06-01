<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class UserProvider extends Model
{
    use LogsActivity;

    protected $table = 'user_providers';

    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('user_provider')
            ->logOnly(['user_id', 'provider', 'provider_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
