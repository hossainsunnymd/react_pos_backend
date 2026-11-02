<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login',[AuthController::class,'login']);

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetOtp']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetWithOtp']);

Route::middleware('auth:sanctum')->group(function () {
    //auth
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/profile',[AuthController::class,'profile']);

    //users
    Route::get('/users',[UserController::class,'index']);
    Route::post('/users',[UserController::class,'store']);
    Route::put('/users/{user}',[UserController::class,'update']);
    Route::delete('/users/{user}',[UserController::class,'delete']);


});
