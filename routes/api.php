<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

Route::post('/user', [UserController::class, 'create']);

Route::apiResource('/post', PostController::class)->only([
  'index', 'store', 'show', 'destroy'
]);

Route::post('/like', [LikeController::class, 'store']);
Route::delete('/like', [LikeController::class, 'destroy']);
Route::get('/like/count', [LikeController::class, 'countlikes']);
Route::get('/like', [LikeController::class, 'haslike']);

Route::post('/comment', [CommentController::class, 'store']);
Route::get('/comment', [CommentController::class, 'show']);