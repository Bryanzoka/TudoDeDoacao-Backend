<?php

use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\AuthController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('jwt.auth');

Route::apiResource('users', UserController::class)->except([
    'create',
    'edit'
]);

Route::get('/donations/getmydonations', [DonationController::class, 'getMyDonations'])->middleware('jwt.auth');

Route::get('/donations/getbylocation/{location}', [DonationController::class, 'getByLocation']);

Route::get('/donations/getbymylocation', [DonationController::class, 'getByMyLocation'])->middleware('jwt.auth');

Route::get('/donations/getbycategory/{category}', [DonationController::class, 'getByCategory']);

Route::get('/donations/getbyname/{name}', [DonationController::class, 'getByName']);

Route::get('/donations/favorites', [FavoriteController::class, 'myFavorites'])->middleware('jwt.auth');

Route::apiResource('donations', DonationController::class)->except([
    'create',
    'edit'
])->middleware('jwt.auth');

Route::get('/donations/users/{id}', [DonationController::class, 'getByUser']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('jwt.auth');

Route::post('/donations/favorites/{donation}', [FavoriteController::class, 'favorite'])->middleware('jwt.auth');

Route::delete('/donations/favorites/{donation}', [FavoriteController::class, 'unfavorite'])->middleware('jwt.auth');