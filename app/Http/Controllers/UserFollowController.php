<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFollowCreateRequest;
use App\Service\UserFollowService;
use Illuminate\Http\Request;

class UserFollowController extends Controller
{
    public function __construct(
        private readonly UserFollowService $userFollowService
    )
    {}

    public function store(UserFollowCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->userFollowService->create($request->validated());

        return response()->json([
            'message' => 'followed successfully',
            'code' => 200
        ]);
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = (int) $request->get('per_page', 10);
        $page = (int) $request->get('page', 1);
        $userFollow = $this->userFollowService->getByUserId(auth()->id(), $perPage, $page);

        return response()->json([
            'data' => $userFollow->items(),
            'page' => $userFollow->currentPage(),
            'code' => 200
        ]);
    }

    public function destroy(int $followId): \Illuminate\Http\JsonResponse
    {
        $this->userFollowService->delete($followId);

        return response()->json([
            'message' => 'Unfollowed successfully',
            'code' => 200
        ]);
    }
}
