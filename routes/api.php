<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'create');
    Route::post('/login', 'login');
    Route::post('/request-otp', 'requestOtp');
    Route::post('/confirm-otp', 'confirmOtp');
    Route::post('/user/change-password', 'updatePassword');
    Route::post('/refresh-token', 'refresh');
});

Route::middleware('user')->group(function () {
    Route::post('/track/create', [\App\Http\Controllers\SongController::class, 'create']);
    Route::get('/tracks', [\App\Http\Controllers\SongController::class, 'index']);
    Route::get('/track/{shareToken}', [\App\Http\Controllers\SongController::class, 'get']);
    Route::get('/track/{shareToken}/stream/music', [\App\Http\Controllers\SongController::class, 'streamMusic']);
    Route::get('/track/{shareToken}/stream/photo', [\App\Http\Controllers\SongController::class, 'streamPhoto']);
    Route::delete('/track/{shareToken}', [\App\Http\Controllers\SongController::class, 'destroy']);
    Route::post('/playlist/create', [\App\Http\Controllers\PlaylistController::class, 'create']);
    Route::get('/playlists', [\App\Http\Controllers\PlaylistController::class, 'index']);
    Route::get('/playlist/{shareToken}', [\App\Http\Controllers\PlaylistController::class, 'get']);
    Route::delete('/playlist/{shareToken}', [\App\Http\Controllers\PlaylistController::class, 'destroy']);
    Route::post('/playlist/add-track', [\App\Http\Controllers\PlaylistSongController::class, 'create']);
    Route::delete('/playlist/track/{id}', [\App\Http\Controllers\PlaylistSongController::class, 'destroy']);
    Route::post('/collection/track/create', [\App\Http\Controllers\FavoriteController::class, 'create']);
    Route::get('/collection/tracks', [\App\Http\Controllers\FavoriteController::class, 'index']);
    Route::get('/collection/track/{id}', [\App\Http\Controllers\FavoriteController::class, 'get']);
    Route::delete('/collection/track/{id}', [\App\Http\Controllers\FavoriteController::class, 'destroy']);
    Route::get('/album/{shareToken}', [\App\Http\Controllers\AlbumController::class, 'getByToken']);
    Route::get('/category/{shareToken}', [\App\Http\Controllers\CategoryController::class, 'getByToken']);
    Route::get('/artist/{shareToken}', [\App\Http\Controllers\ArtistController::class, 'getByToken']);
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
    Route::get('/user/{id}', [\App\Http\Controllers\UserController::class, 'get']);
    Route::get('/search', [\App\Http\Controllers\SearchController::class, 'search']);
    Route::post('/follow', [\App\Http\Controllers\UserFollowController::class, 'store']);
    Route::get('/follow', [\App\Http\Controllers\UserFollowController::class, 'index']);
    Route::delete('/follow/{id}', [\App\Http\Controllers\UserFollowController::class, 'destroy']);
    Route::post('/album/follow', [\App\Http\Controllers\AlbumFollowController::class, 'store']);
    Route::get('/albums/follow', [\App\Http\Controllers\AlbumFollowController::class, 'index']);
    Route::delete('/album/follow/{id}', [\App\Http\Controllers\AlbumFollowController::class, 'destroy']);
    Route::post('/artist/follow', [\App\Http\Controllers\ArtistFollowController::class, 'store']);
    Route::get('/artists/follow', [\App\Http\Controllers\ArtistFollowController::class, 'index']);
    Route::delete('/artist/follow/{id}', [\App\Http\Controllers\ArtistFollowController::class, 'destroy']);
    Route::post('/playlist/follow', [\App\Http\Controllers\PlaylistFollowController::class, 'store']);
    Route::get('/playlists/follow', [\App\Http\Controllers\PlaylistFollowController::class, 'index']);
    Route::delete('/playlist/follow/{id}', [\App\Http\Controllers\PlaylistFollowController::class, 'destroy']);
});
