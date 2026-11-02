<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',[AuthController::class,'login']);

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
