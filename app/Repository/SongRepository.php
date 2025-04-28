<?php

namespace App\Repository;

use App\Models\Song;
use Illuminate\Support\Str;

class SongRepository
{
    public function create(array $data)
    {
        do {
            $shareToken = Str::random(16);
        } while (Song::query()->where('share_token', $shareToken)->exists());

        return Song::query()->create([
            'title' => $data['title'],
            'artist_id' => $data['artist_id'] ?? null,
            'album_id' => $data['album_id'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'created_by' => auth()->id(),
            'share_token' => $shareToken,
        ]);
    }

    public function existsByTitleForUser(string $title, int $userId): bool
    {
        return Song::query()
            ->where('title', $title)
            ->where('created_by', $userId)
            ->exists();
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return Song::query()
            ->where('created_by', auth()->id())
            ->with(['media'])
            ->get();
    }

    public function get(string $shareToken): \Illuminate\Database\Eloquent\Model|null
    {
        return Song::query()
            ->where('created_by', auth()->id())
            ->where('share_token', $shareToken)
            ->with(['media'])
            ->first();
    }


}
