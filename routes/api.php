<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Models\Order;

Route::group(['middleware' => ['VeryfyApiKey']], function () {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('loginGoogle', [AuthController::class, 'loginWithGoogle']);

    Route::group(['middleware' => ['cors']], function () {
        Route::get('auth/google', [AuthController::class, 'redirectToGoogle']);
        Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
        
        Route::post('login', [AuthController::class, 'login'])->middleware('throttle:rateLimiterku');
    });
    

    Route::get('user/{id}', [UserController::class, 'getMe']);
    Route::get('room', [RoomController::class, 'show']);
    Route::put('room/update-quantities', [RoomController::class, 'updateQuantities']);

    Route::get('order/{userId}', [OrderController::class, 'showByUser']);
    Route::get('order', [OrderController::class, 'getOrders']);
    Route::post('order', [OrderController::class, 'order']);
    Route::post('order/pay/{id_order}', [OrderController::class, 'pay']);

    Route::post('order/checkStatus/{id_order}', [OrderController::class, 'checkStatus']);
    Route::post('order/checkout/{id_order}', [OrderController::class, 'checkoutNow']);

    Route::delete('order/{id_order}', [OrderController::class, 'destroy']);
    Route::delete('order/delete/{id_order}', [OrderController::class, 'delete']);

    Route::post('logout', [AuthController::class, 'logout']);
});

