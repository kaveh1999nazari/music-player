<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserHistoryCreateRequest;
use App\Service\UserHistoryService;
use Illuminate\Http\Request;

class UserHistoryController extends Controller
{
    public function __construct(
        private readonly UserHistoryService $userHistoryService
    ) {}

    public function store(UserHistoryCreateRequest $request)
    {

        $history = $this->userHistoryService->log($request->validated());

        return response()->json([
            'data' => $history,
            'status' => 201
        ]);
    }

    public function recent(): \Illuminate\Http\JsonResponse
    {
        $recent = $this->userHistoryService->getRecent();
        return response()->json([
            'data' => $recent
        ]);
    }
}
