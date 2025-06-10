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
        $user = $this->userService->create($request->validated(), $request->file('photo'));

        return response()->json([
            'id' => $user->id,
            'code' => 201,
        ]);
    }

    /**
     * @throws UserNotAdminException
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = (int) $request->get('per_page', 10);
        $page = (int) $request->get('page', 1);
        $users = $this->userService->all($perPage, $page);

        return response()->json([
            'data' => $users->items(),
            'page' => $users->currentPage(),
            'code' => 200
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

    public function streamPhoto(int $id): \Illuminate\Http\JsonResponse
    {
        $url = $this->userService->streamPhoto($id);

        return response()->json([
            'url' =>  $url,
        ]);


    }

}
