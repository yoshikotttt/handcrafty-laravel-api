<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\FollowsController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\RequestsController;
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



    //マイページ(ログインユーザー)
    Route::get('/users/me', [UsersController::class, 'myProfile']);
    //プロフィール編集ページのための情報取得
    Route::get('/users/profile', [UsersController::class, 'getProfileEditData']);
    //プロフィール更新
    Route::put('/users/profile', [UsersController::class, 'update']);
    //マイページ(訪問先)
    Route::get('/users/{user_id}', [UsersController::class, 'getProfile']);

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


    // ----- フォロー -----------
    //フォロー登録
    Route::post('/posts/{user_id}/follow', [FollowsController::class, 'create']);
    //フォロー削除
    Route::delete('/posts/{user_id}/follow', [FollowsController::class, 'destroy']);
    //フォローの情報があるかのチェック(is-following)
    Route::get('/posts/{user_id}/follow/check', [FollowsController::class, 'check']);

    //ログインユーザーのフォロワー
    Route::get('/users/me/followers', [FollowsController::class, 'myFollowers']);
    //ログインユーザーのフォロー中
    Route::get('/users/me/following', [FollowsController::class, 'myFollowing']);
    //訪問先ユーザーのフォロワー
    Route::get('/users/{user_id}/followers', [FollowsController::class, 'followers']);
    //訪問先ユーザーのフォロー中
    Route::get('/users/{user_id}/following', [FollowsController::class, 'following']);


    // ------ リクエスト -----------
    //新規リクエスト
    Route::post('/request', [RequestsController::class, 'create']);
    //未読通知数の取得
    Route::get('/notifications/unread/count', [NotificationsController::class, 'getUnreadNotificationsCount']);
    //全通知の取得
    Route::get('/all-notifications', [NotificationsController::class, 'getAllNotifications']);
    // Route::get('/notifications', [NotificationsController::class, 'index']);
    //通知詳細
    Route::get('/notifications/{id}', [NotificationsController::class, 'show']);
    //statusの更新
    Route::put('/notifications/{id}', [NotificationsController::class, 'update']);

    // ------- メッセージ ------------
    //新規メッセージ
    Route::post('/chat/{roomId}', [MessagesController::class, 'create']);
    //全メッセージ取得
    Route::get('/chat/{roomId}', [MessagesController::class, 'index']);
    //メッセージのやりとりがあるID
    Route::get('/chat/users/all', [MessagesController::class, 'chatUsersList']);



});





    //テスト
    Route::get('test', function () {
        return response()->json(['message' => 'This is a protected route!']);
    });

    Route::get('user', function (Request $request) {
        return $request->user();
    });