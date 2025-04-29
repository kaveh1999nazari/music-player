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

    public function index()
    {
        $favorite = $this->favoriteService->all();

        return response()->json([
            'data' => $favorite,
            'code' => 200
        ]);
    }

    public function get(int $id)
    {
        $favorite = $this->favoriteService->get($id);

        return response()->json([
            'data' => $favorite,
            'code' => 200
        ]);
    }

    public function destroy(int $id)
    {
        $favorite = $this->favoriteService->delete($id);
        return response()->json([
            'message' => 'باموفقیت از لیست مورد علاقه شما حذف شد',
            'code' => 200
        ]);
    }
}
