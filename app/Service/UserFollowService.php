<?php

namespace App\Service;

use App\Exceptions\UserFollowBeforeException;
use App\Exceptions\UserFollowNotAllow;
use App\Exceptions\UserNotFound;
use App\Models\UserFollow;
use App\Repository\UserFollowRepository;
use App\Repository\UserRepository;

class UserFollowService
{
    public function __construct(
        private readonly UserFollowRepository $userFollowRepository,
        private readonly UserRepository       $userRepository,
    )
    {
    }

    public function create(array $data): UserFollow
    {
        $userIdFollow = $this->userRepository->getById($data['following_user_id']);

        if (!$userIdFollow) {
            throw new UserNotFound();
        }

        $userId = auth()->id();

        if ($userId === $userIdFollow->id) {
            throw new UserFollowNotAllow();
        }

        if ($this->userFollowRepository->checkExist($userId, $data['following_user_id'])) {
            throw new UserFollowBeforeException();
        }

        return $this->userFollowRepository->create($data);
    }

    public function delete(int $id)
    {
        return $this->userFollowRepository->delete($id);
    }

    public function get(int $id)
    {
        return $this->userFollowRepository->get($id);
    }

    public function getByUserId(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->userFollowRepository->getByUserId($userId);
    }
}
