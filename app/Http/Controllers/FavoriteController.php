<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteCreateRequest;
use App\Service\FavoriteService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct(
        private readonly FavoriteService $favoriteService
    )
    {}

    public function create(FavoriteCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $favorite = $this->favoriteService->create($request->validated());

        return response()->json([
            'id' => $favorite->id,
            'code' => 201
        ]);
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = (int) $request->get('per_page', 10);
        $page = (int) $request->get('page', 1);
        $favorite = $this->favoriteService->all($perPage, $page);

        return response()->json([
            'data' => $favorite->items(),
            'page' => $favorite->currentPage(),
            'code' => 200
        ]);
    }

    public function get(int $id): \Illuminate\Http\JsonResponse
    {
        $favorite = $this->favoriteService->get($id);

        return response()->json([
            'data' => $favorite,
            'code' => 200
        ]);
    }

    public function destroy(int $id)
    {
        $this->favoriteService->delete($id);
        return response()->json([
            'message' => 'Item removed from favorites successfully',
            'code' => 200
        ]);
    }
}
