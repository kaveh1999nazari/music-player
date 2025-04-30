<?php

namespace App\Trait;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait GeneratesUniqueShareToken
{
    public function generateUniqueShareToken(): string
    {
        do {
            $token = Str::random(16);
        } while (
            DB::table('songs')->where('share_token', $token)->exists() ||
            DB::table('playlists')->where('share_token', $token)->exists() ||
            DB::table('categories')->where('share_token', $token)->exists() ||
            DB::table('artists')->where('share_token', $token)->exists() ||
            DB::table('albums')->where('share_token', $token)->exists()
        );

        return $token;
    }
}
