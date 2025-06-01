<?php

namespace App\Http\Controllers;

use App\Exceptions\UserExistException;
use App\Exceptions\UserNotAdminException;
use App\Exceptions\UserNotFound;
use App\Exceptions\UserPasswordIncorrect;
use App\Http\Requests\UserConfirmOtpRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRequestOtpRequest;
use App\Http\Requests\UserUpdatePasswordRequest;
use App\Service\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    )
    {}

    /**
     * @throws UserExistException
     */
    public function create(UserCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = $this->userService->create($request->validated());

        return response()->json([
            'id' => $user->id,
            'code' => 201,
        ]);
    }

    /**
     * @throws UserNotAdminException
     */
    public function index()
    {
        return response()->json([
            'data' => $this->userService->all(),
            'code' => 201
        ]);
    }

    /**
     * @throws UserNotAdminException
     */
    public function get(int $id): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data' => $this->userService->getById($id),
            'code' => 201
        ]);
    }

    /**
     * @throws UserNotFound
     */
    public function updatePassword(UserUpdatePasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = $this->userService->updatePassword($request->validated());

        return response()->json([
            'message' => 'Password updated successfully',
            'code' => 201
        ]);
    }

    /**
     * @throws UserNotFound
     * @throws UserPasswordIncorrect
     */
    public function login(UserLoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $token = $this->userService->login($request->validated());

        return response()->json([
            'token' => $token,
        ]);
    }

    public function requestOtp(UserRequestOtpRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = $this->userService->requestOtp($request->validated());

        return response()->json([
            'otp_code' => $user->otp_code,
            'code' => 201
        ]);
    }

    /**
     * @throws UserNotFound
     * @throws UserPasswordIncorrect
     */
    public function confirmOtp(UserConfirmOtpRequest $request)
    {
        $token = $this->userService->confirmOtp($request->validated());

        return response()->json([
            'token' => $token,
            'code' => 200
        ]);
    }

    /**
     * @throws \Exception
     */
    public function refresh(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->userService->refreshToken($request->input('refresh_token'));
    }

}
