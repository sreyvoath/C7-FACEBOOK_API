<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\FriendRequestController;
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

Route::middleware('auth:sanctum')->group(function () {

    //Post 
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/post/create', [PostController::class, 'store']);
    Route::get('/post/show/{id}', [PostController::class, 'show']);
    Route::post('/post/update/{id}', [PostController::class, 'update']);
    Route::delete('/post/delete/{id}', [PostController::class, 'destroy']);

    //Like
    Route::post('/like', [LikeController::class, 'create']);
    Route::get('/like', [LikeController::class, 'list']);

    //Comment
    Route::post('/comment', [CommentController::class, 'create']);
    Route::get('/comment', [CommentController::class, 'list']);
    Route::delete('/comment/{id}', [CommentController::class, 'destroy']);

    //Friendship
    Route::post('/friend-request', [FriendRequestController::class, 'sendRequest']);
    Route::post('/friend-request/accept', [FriendRequestController::class, 'acceptRequest']);
    Route::post('/friend-request/reject', [FriendRequestController::class, 'rejectRequest']);
    Route::get('/friend-requests/received/pending', [FriendRequestController::class, 'getPendingRequests']);
    Route::get('/friends', [FriendRequestController::class, 'getFriends']);
    Route::delete('/friend/remove', [FriendRequestController::class, 'removeFriend']);
});
