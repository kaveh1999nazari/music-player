<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    use LogsActivity;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'share_token',
    ];

    public function songCategory(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SongCategory::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('category')
            ->logOnly(['name', 'share_token'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
