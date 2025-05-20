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
            'message' => 'با موفقیت دنبال شد',
            'code' => 200
        ]);
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $userFollow = $this->userFollowService->getByUserId(auth()->id());

        return response()->json([
            'data' => $userFollow,
            'code' => 200
        ]);
    }

    public function destroy(int $followId): \Illuminate\Http\JsonResponse
    {
        $this->userFollowService->delete($followId);

        return response()->json([
            'message' => 'با موفقیت آنفالو شد',
            'code' => 200
        ]);
    }
}
