<?php

namespace App\Service;

use App\Exceptions\UserNotAdminException;
use App\Repository\UserHistoryRepository;

class UserHistoryService
{
    public function __construct(
        private readonly UserHistoryRepository $userHistoryRepository
    ) {}

    public function log(array $data)
    {
        if (auth()->user()->is_admin === true) {
            return $this->userHistoryRepository->store($data);
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
}
