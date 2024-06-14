<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Atuthentication 
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Password Reset
Route::post('/password/email', [AuthController::class, 'sendEmailVerify']);
Route::post('/password/reset', [AuthController::class, 'resetPassword']);

//Profile 
Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum');
Route::put('/me/{id}', [UserController::class, 'update']);
Route::post('/upload/{id}', [UserController::class, 'uploadProfilePicture']);

//User
Route::get('/users', [UserController::class, 'index']);
// Route::get('/users/{id}', [UserController::class, 'show']);
// Route::post('/users/create', [UserController::class, 'store']);
// Route::put('/users/update{id}', [UserController::class, 'update']);
// Route::delete('/users/delete{id}', [UserController::class, 'destroy']);

//Post 
Route::post('/posts', [PostController::class, 'index'])->middleware('auth:sanctum');
Route::post('/post/create', [PostController::class, 'store'])->middleware('auth:sanctum');
Route::post('/post/show/{id}', [PostController::class, 'show'])->middleware('auth:sanctum');
Route::post('/post/update/{id}', [PostController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/post/delete/{id}', [PostController::class, 'destroy'])->middleware('auth:sanctum');

//Like
Route::post('/like', [LikeController::class, 'create'])->middleware('auth:sanctum');
Route::get('/like', [LikeController::class, 'list'])->middleware('auth:sanctum');

//Comment
Route::post('/comment', [CommentController::class, 'create'])->middleware('auth:sanctum');
Route::get('/comment', [CommentController::class, 'list'])->middleware('auth:sanctum');
Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->middleware('auth:sanctum');

//Friendship

