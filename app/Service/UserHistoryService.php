<?php

namespace App\Service;

use App\Exceptions\NotFoundItemException;
use App\Exceptions\UserNotAdminException;
use App\Repository\UserHistoryRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserHistoryService
{
    public function __construct(
        private readonly UserHistoryRepository $userHistoryRepository
    ) {}

    public function log(array $data)
    {
        if (auth()->user()->is_admin === true) {
            $modelClass = $this->resolveModelClass($data['item_type']);

            $model = $modelClass::find($data['item_id']);

            if (! $model) {
                throw new NotFoundItemException();
            }
            return $this->userHistoryRepository->store($modelClass, $model->id, $data['action']);
        }else {
            throw new UserNotAdminException();
        }
    }

    public function getRecent(): \Illuminate\Database\Eloquent\Collection
    {
        if (auth()->user()->is_admin === true) {
            return $this->userHistoryRepository->getRecent();
        }else {
            throw new UserNotAdminException();
        }
    }

    private function resolveModelClass(string $type): string
    {
        return match(strtolower($type)) {
            'song'   => \App\Models\Song::class,
            'album'  => \App\Models\Album::class,
            'artist' => \App\Models\Artist::class,
            'playlist' => \App\Models\Playlist::class,
            default  => throw new \InvalidArgumentException("Unknown item type: $type"),
        };
    }
}
