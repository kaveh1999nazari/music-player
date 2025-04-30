<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserLoginRequest;
use App\Service\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    )
    {}

    public function create(UserCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = $this->userService->create($request->validated());

        return response()->json([
            'id' => $user->id,
            'code' => 201,
        ]);
    }

    public function index()
    {
        return response()->json([
            'data' => $this->userService->all(),
            'code' => 201
        ]);
    }

    public function get(int $id)
    {
        return response()->json([
            'data' => $this->userService->getById($id),
            'code' => 201
        ]);
    }

    public function login(UserLoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $token = $this->userService->login($request->validated());

        return response()->json([
            'token' => $token,
        ]);
    }
}
