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
    Route::post('/track/create', [\App\Http\Controllers\SongController::class, 'create']);
    Route::get('/tracks', [\App\Http\Controllers\SongController::class, 'index']);
    Route::get('/track/{shareToken}', [\App\Http\Controllers\SongController::class, 'get']);
    Route::delete('/track/{shareToken}', [\App\Http\Controllers\SongController::class, 'destroy']);
    Route::post('/playlists/create', [\App\Http\Controllers\PlaylistController::class, 'create']);
    Route::get('/playlists', [\App\Http\Controllers\PlaylistController::class, 'index']);
    Route::get('/playlist/{shareToken}', [\App\Http\Controllers\PlaylistController::class, 'get']);
    Route::delete('/playlist/{shareToken}', [\App\Http\Controllers\PlaylistController::class, 'destroy']);
    Route::post('/playlist/add-track', [\App\Http\Controllers\PlaylistSongController::class, 'create']);
    Route::delete('/playlist/track/{id}', [\App\Http\Controllers\PlaylistSongController::class, 'destroy']);
    Route::post('/collection/track/create', [\App\Http\Controllers\FavoriteController::class, 'create']);
    Route::get('/collection/tracks', [\App\Http\Controllers\FavoriteController::class, 'index']);
    Route::get('/collection/track/{id}', [\App\Http\Controllers\FavoriteController::class, 'get']);
    Route::delete('/collection/track/{id}', [\App\Http\Controllers\FavoriteController::class, 'destroy']);
});
