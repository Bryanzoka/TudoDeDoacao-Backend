<?php

use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/* Route::apiResource('/users', UserController::class)->except([
    'create',
    'edit'
]); */

Route::post('users', [UserController::class, 'store']);
Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);

Route::post('auth/refresh', [AuthController::class, 'refresh']);

Route::middleware(['jwt.auth', 'role'])->group(function() {
    Route::patch('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
});

Route::apiResource('/donations', DonationController::class)->except([
    'create',
    'edit'
    ])->middleware('jwt.auth');
    
    
    Route::post('/auth/request-verification-code', [AuthController::class, 'requestCode']);
    
    Route::get('/donations/location/{location}', [DonationController::class, 'getByLocation']);
    
    Route::get('/donations/category/{category}', [DonationController::class, 'getByCategory']);
    
    Route::get('/donations/search/{name}', [DonationController::class, 'getByName']);
    
    Route::middleware('jwt.auth')->group(function() {
        Route::get('/users/{id}/donations', [DonationController::class, 'getByUser']);
        Route::get('/donations/location', [DonationController::class, 'getByMyLocation']);
        Route::get('/donations/favorites', [FavoriteController::class, 'myFavorites']);
        Route::post('/donations/favorites/{donation}', [FavoriteController::class, 'favorite']);
        Route::delete('/donations/favorites/{donation}', [FavoriteController::class, 'unfavorite']);
        Route::get('/donations/search', [DonationController::class, 'getFiltered']);

    Route::get('/messages', [MessageController::class, 'index']);
    Route::post('/messages', [MessageController::class, 'store']);
});


Route::post('/auth/login', [AuthController::class, 'login']);





