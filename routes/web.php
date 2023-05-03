<?php

use App\Http\Controllers\ChatGPTController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ユーザー認証
Auth::routes();

// プロフィール
Route::resource('/users', UserController::class)->only(['show', 'edit', 'update']);
Route::get('/users/{user}/likes', [UserController::class, 'likes'])->name('users.likes');

// プログラミング学習
Route::get('/', [RecordController::class, 'index'])->name('top');
Route::resource('/records', RecordController::class)->except(['index', 'show'])->middleware('auth');
Route::resource('/records', RecordController::class)->only('show');

// ChatGPT
Route::get('/records/{record}/advice', [ChatGPTController::class, 'getAdvice'])->name('chatgpt.getAdvice')->middleware('auth');

// いいね
Route::prefix('/records')
    ->name('likes.')
    ->controller(LikeController::class)
    ->middleware('auth')
    ->group(function () {
        Route::put('{record}/like', 'store')->name('store');
        Route::delete('{record}/unlike', 'destroy')->name('destroy');
    });

// コメント
Route::resource('/records/comments', CommentController::class)->only(['create', 'edit', 'update', 'destroy'])->middleware('auth');
