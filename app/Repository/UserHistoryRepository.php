<?php

namespace App\Repository;

use App\Models\UserHistory;
use Illuminate\Support\Facades\Auth;

class UserHistoryRepository
{
    public function store(string $itemType, int $itemId, string $action): UserHistory
    {
        return UserHistory::query()
            ->create([
                'user_id'    => auth()->id(),
                'item_type'  => $itemType,
                'item_id'    => $itemId,
                'action'     => $action,
        ]);
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
