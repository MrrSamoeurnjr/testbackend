<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoomFeatureController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\RoleController;
Route::prefix('v1')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('properties', PropertyController::class);
    Route::apiResource('rooms', RoomController::class);
    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('payments', PaymentController::class);
    Route::apiResource('messages', MessageController::class);
    Route::apiResource('reviews', ReviewController::class);
    Route::apiResource('room-features', RoomFeatureController::class);
    Route::apiResource('deposits', DepositController::class);
    Route::apiResource('floors', FloorController::class);
    Route::apiResource('policies', RoleController::class);
});

