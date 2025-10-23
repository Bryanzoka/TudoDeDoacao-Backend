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

Route::post('/auth/request-verification-code', [AuthController::class, 'requestCode']);

Route::get('/donations/my', [DonationController::class, 'getMyDonations'])->middleware('jwt.auth');

Route::get('/email', function () {
    return view('emails.email');
});

Route::get('/donations/location/{location}', [DonationController::class, 'getByLocation']);

Route::get('/donations/location', [DonationController::class, 'getByMyLocation'])->middleware('jwt.auth');

Route::get('/donations/category/{category}', [DonationController::class, 'getByCategory']);

Route::get('/donations/search/{name}', [DonationController::class, 'getByName']);

Route::get('/donations/favorites', [FavoriteController::class, 'myFavorites'])->middleware('jwt.auth');

Route::apiResource('donations', DonationController::class)->except([
    'create',
    'edit'
])->middleware('jwt.auth');

Route::get('/donations/users/{id}', [DonationController::class, 'getByUser']);

Route::post('/auth/login', [AuthController::class, 'login']);

Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('jwt.auth');

Route::post('/donations/favorites/{donation}', [FavoriteController::class, 'favorite'])->middleware('jwt.auth');

Route::delete('/donations/favorites/{donation}', [FavoriteController::class, 'unfavorite'])->middleware('jwt.auth');