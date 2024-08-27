<?php

use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Models\Comment;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::Post('/posts/{post}/comments', [CommentController::class, 'store']);

    Route::get('/posts/{post}/comments', [CommentController::class, 'getComments']);
    Route::delete('/posts/{post}/comments/{comment}', [CommentController::class, 'deleteComment']);
});
