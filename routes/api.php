<?php

use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\AuthController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/users', UserController::class)->except([
    'create',
    'edit'
]);

Route::post('/auth/request-verification-code', [AuthController::class, 'requestCode']);

Route::get('/email', function () {
    return view('emails.email');
});

Route::get('/donations/location/{location}', [DonationController::class, 'getByLocation']);

Route::get('/donations/category/{category}', [DonationController::class, 'getByCategory']);

Route::get('/donations/search/{name}', [DonationController::class, 'getByName']);

Route::apiResource('donations', DonationController::class)->except([
    'create',
    'edit'
]);

Route::middleware('jwt.auth')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/donations/my', [DonationController::class, 'getMyDonations']);
    Route::get('/donations/location', [DonationController::class, 'getByMyLocation']);
    Route::get('/donations/favorites', [FavoriteController::class, 'myFavorites']);
    // Route::apiResource('donations', DonationController::class)->except(['create', 'edit']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/donations/favorites/{donation}', [FavoriteController::class, 'favorite']);
    Route::delete('/donations/favorites/{donation}', [FavoriteController::class, 'unfavorite']);
});


Route::get('/donations/users/{id}', [DonationController::class, 'getByUser']);

Route::post('/auth/login', [AuthController::class, 'login']);





