<?php

use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PendingDonationController;
use Illuminate\Support\Facades\Route;

Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);
Route::post('users', [UserController::class, 'store']);

Route::middleware(['jwt.auth', 'role'])->group(function() {
    Route::patch('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
});

Route::apiResource('/donations', DonationController::class)->except([
    'create',
    'edit'
])->middleware('jwt.auth');

Route::middleware('jwt.auth')->group(function () {
    Route::get('/users/{id}/donations', [DonationController::class, 'getByUser']);
    Route::get('/users/{userId}/pending', [PendingDonationController::class, 'GetUserPendingDonations']);
    Route::get('/users/{userId}/received-pendings', [PendingDonationController::class, 'getPendingsReceived']);
    Route::get('/donations', [DonationController::class, 'getFiltered']);

    Route::get('/messages', [MessageController::class, 'index']);
    Route::post('/messages', [MessageController::class, 'store']);

    // Route::post('/donations/pending', [PendingDonationController::class, 'setPending']);
    Route::post('/donations/pending', [PendingDonationController::class, 'store']);
    Route::delete('/donations/pending', [PendingDonationController::class, 'delete']);

    Route::get('/donations/accepted{id}', []);
    Route::post('/donations/accepted', []);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});


Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('auth/refresh', [AuthController::class, 'refresh']);
Route::post('/auth/request-verification-code', [AuthController::class, 'requestCode']);

Route::get('/debug/logs', function () {
    return response()->file(storage_path('logs/laravel.log'));
});
