<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\ProductController;
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

    //customers
    Route::get('/customers',[CustomerController::class,'index']);
    Route::post('/customers',[CustomerController::class,'store']);
    Route::put('/customers/{customer}',[CustomerController::class,'update']);
    Route::delete('/customers/{customer}',[CustomerController::class,'delete']);

    //categories
    Route::get('/categories',[CategoryController::class,'index']);
    Route::post('/categories',[CategoryController::class,'store']);
    Route::put('/categories/{category}',[CategoryController::class,'update']);
    Route::delete('/categories/{category}',[CategoryController::class,'delete']);

    //products
    Route::get('/products',[ProductController::class,'index']);
    Route::post('/products',[ProductController::class,'store']);
    Route::put('/products/{product}',[ProductController::class,'update']);
    Route::delete('/products/{product}',[ProductController::class,'delete']);

    //invoices
    Route::get('/invoices',[InvoiceController::class,'index']);
    Route::post('/invoices',[InvoiceController::class,'store']);


});
