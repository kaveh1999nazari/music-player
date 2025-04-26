<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'create');
    Route::post('/login', 'login');
});

Route::middleware('auth:api')->group(function () {
    Route::post('songs/create', [\App\Http\Controllers\SongController::class, 'create']);
});
