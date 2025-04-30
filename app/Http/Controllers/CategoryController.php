<?php

namespace App\Http\Controllers;

use App\Service\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService
    )
    {}

    public function getByToken(string $shareToken)
    {
        $category = $this->categoryService->getByToken($shareToken);

        return response()->json([
            'data' => $category,
            'code' => 201
        ]);
    }
}
