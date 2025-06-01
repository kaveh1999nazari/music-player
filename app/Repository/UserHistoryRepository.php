<?php

namespace App\Repository;

use App\Models\UserHistory;

class UserHistoryRepository
{
    public function store(array $data): UserHistory
    {
        $data['user_id'] = Auth::id();
        return UserHistory::create($data);
    }

    public function getRecent(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return UserHistory::with('item')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }
}
