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

Route::middleware('user')->group(function () {
    Route::post('/songs/create', [\App\Http\Controllers\SongController::class, 'create']);
    Route::get('/songs', [\App\Http\Controllers\SongController::class, 'index']);
    Route::get('/songs/{shareToken}', [\App\Http\Controllers\SongController::class, 'get']);
    Route::delete('/songs/{shareToken}', [\App\Http\Controllers\SongController::class, 'destroy']);
    Route::post('/playlists/create', [\App\Http\Controllers\PlaylistController::class, 'create']);
    Route::get('/playlists', [\App\Http\Controllers\PlaylistController::class, 'index']);
    Route::get('/playlists/{shareToken}', [\App\Http\Controllers\PlaylistController::class, 'get']);
    Route::delete('/playlists/{shareToken}', [\App\Http\Controllers\PlaylistController::class, 'destroy']);
    Route::post('/playlists/add-song', [\App\Http\Controllers\PlaylistSongController::class, 'create']);
});
