<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


// Auth routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

// Protected routes
Route::middleware('jwt.auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    Route::get('users', [AuthController::class, 'get']);
});


// Only accessible by admins
Route::middleware(['jwt.auth', 'role:admin'])->group(function () {
    
});

// Only accessible by customers
Route::middleware(['jwt.auth', 'role:customer'])->group(function () {
    
});
