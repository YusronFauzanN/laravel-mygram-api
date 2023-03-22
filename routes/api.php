<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Photos\PhotoController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth API
Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login']);
Route::post('logout',[AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('users/logout',[UserController::class, 'logout']);

    
    // Users API
    Route::patch('users/update',[UserController::class, 'update'])->middleware(['update-user']);
    Route::get('users/profile',[UserController::class, 'profile'])->middleware(['update-user']);


    // Photos API
    Route::get('photos',[PhotoController::class, 'getPhoto']);
    Route::get('photos/{id}',[PhotoController::class, 'show']);
    Route::post('photos/create',[PhotoController::class, 'store']);
    Route::patch('photos/update/{id}',[PhotoController::class, 'update'])->middleware(['update-photo']);
    Route::delete('photos/{id}',[PhotoController::class, 'destroy'])->middleware(['update-photo']);

    // Comments API
    Route::get('comments',[CommentController::class, 'getComment']);
    Route::get('comments/{id}',[CommentController::class, 'show']);
    Route::post('comments/create',[CommentController::class, 'store']);
    Route::patch('comments/update/{id}',[CommentController::class, 'update'])->middleware(['update-comment']);
    Route::delete('comments/{id}',[CommentController::class, 'destroy'])->middleware(['update-comment']);


    Route::get('users/tes',[UserController::class, 'test']);
});


