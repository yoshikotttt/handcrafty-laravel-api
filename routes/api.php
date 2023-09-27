<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\UsersController;




Route::post('/login', LoginController::class)->name('login');
Route::post('/register', [RegisteredUserController::class, 'store']);
//全投稿ページ
Route::get('/posts', [ItemsController::class, 'index']);
//個別投稿ページ
Route::get('/posts/{item_id}', [ItemsController::class, 'show']);

//いいねがあれば件数を表示させる
Route::get('/posts/{item_id}/likes/info', [LikesController::class, 'info']);

Route::middleware('auth:sanctum')->group(function () {
    // ログアウト
    Route::post('/logout', LogoutController::class)->name('logout');



    // マイページ 
    Route::get('/users/me ', [UsersController::class, 'show']);
    //新規投稿
    Route::post('/users/posts/new', [ItemsController::class, 'create']);
    //更新
    Route::put('/users/posts/{item_id}/edit', [ItemsController::class, 'update']);
    //削除
    Route::delete('/posts/{item_id}', [ItemsController::class, 'destroy']);



    // ----- いいね ----------
    //いいね登録
    Route::post('/posts/{item_id}/likes', [LikesController::class, 'create']);
    //いいね削除
    Route::delete('/posts/{item_id}/likes', [LikesController::class, 'destroy']);
    //いいねの情報があるかのチェック(isLiked)
    Route::get('/posts/{item_id}/likes/check', [LikesController::class, 'check']);
    //itemに対する全いいねを取得
    Route::get('/posts/{item_id}/likes', [LikesController::class, 'getAll']);


    // ----- お気に入り ----------
    //お気に入り登録
    Route::post('/posts/{item_id}/favorites', [FavoritesController::class, 'create']);
    //お気に入り削除
    Route::delete('/posts/{item_id}/favorites', [FavoritesController::class, 'destroy']);
    //お気に入りの情報があるかのチェック
    Route::get('/posts/{item_id}/favorites/check', [FavoritesController::class, 'check']);
    //それぞれのuser_idが持つお気に入りの全データ
    Route::get('/favorites', [FavoritesController::class, 'getAll']);
});



    //テスト
    Route::get('test', function () {
        return response()->json(['message' => 'This is a protected route!']);
    });

    Route::get('user', function (Request $request) {
        return $request->user();
    });