<?php

namespace App\Service;

use App\Exceptions\CategoryNotExistException;
use App\Repository\CategoryRepository;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository
    )
    {}

    public function getByToken(string $shareToken)
    {
        $category = $this->categoryRepository->getByToken($shareToken);
        if (! $category) {
            throw new CategoryNotExistException();
        }

        return $category;
    }

    public function getById(int $id)
    {
        $category = $this->categoryRepository->getById($id);
        if (! $category) {
            throw new CategoryNotExistException();
        }

        return $category;
    }
}
