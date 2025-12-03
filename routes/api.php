<?php

use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);
Route::post('users', [UserController::class, 'store']);

Route::middleware(['jwt.auth', 'role'])->group(function() {
    Route::patch('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
});

Route::get('/donations/search', [DonationController::class, 'getFiltered']);
Route::apiResource('/donations', DonationController::class)->except([
    'create',
    'edit'
])->middleware('jwt.auth');

Route::middleware('jwt.auth')->group(function() {
    Route::get('/users/{id}/donations', [DonationController::class, 'getByUser']);
    Route::get('/donations', [DonationController::class, 'getFiltered']);

    Route::get('/messages', [MessageController::class, 'index']);
    Route::post('/messages', [MessageController::class, 'store']);

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});


Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('auth/refresh', [AuthController::class, 'refresh']);
Route::post('/auth/request-verification-code', [AuthController::class, 'requestCode']);