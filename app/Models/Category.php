<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'share_token',
    ];

    public function songCategory(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SongCategory::class);
    }
}
