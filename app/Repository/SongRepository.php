<?php

namespace App\Repository;

use App\Models\Category;
use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SongRepository
{
    public function create(array $data)
    {
        do {
            $shareToken = Str::random(16);
        } while (Song::query()->where('share_token', $shareToken)->exists()
                && Playlist::query()->where('share_token', $shareToken)->exists()
                && Category::query()->where('share_token', $shareToken)->exists());

        return Song::query()->create([
            'title' => $data['title'],
            'created_by' => auth()->id(),
            'share_token' => $shareToken,
            'is_public' => $data['is_public'] ?? true,
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

    public function delete(Song $song): void
    {
        $folderPath = "songs/" . $song->created_by . "/" . $song->title;

        if (Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->deleteDirectory($folderPath);
        }

        foreach ($song->media as $media) {
            $media->delete();
        }

        $song->delete();
    }

    public function getById(int $id)
    {
        return Song::query()
            ->where('id', $id)
            ->first();
    }

}
