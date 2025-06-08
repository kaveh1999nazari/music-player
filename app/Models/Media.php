<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    protected $fillable = [
        'file_path',
        'file_type',
        'mime_type',
        'model_id',
        'model_type',
        'quality',
    ];

    /**
     * مدل چندشکلی که فایل بهش مربوطه
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * آدرس کامل فایل (قابل استفاده در view)
     */
    public function getFullUrlAttribute(): string
    {
        return asset(str_replace('public/', 'storage/', $this->file_path));
    }
}
