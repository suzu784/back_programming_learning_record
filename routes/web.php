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
Route::prefix('/users')->controller(UserController::class)->name('users.')->group(function() {
    Route::get('{user}', 'showRecords')->name('showRecords');
    Route::get('/{user}/likes', 'showLikes')->name('showLikes');
    Route::get('/{user}/edit', 'editGoal')->name('editGoal');
    Route::put('/{user}', 'updateGoal')->name('updateGoal');
});

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
