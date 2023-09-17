<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ItemsController;

Route::post('/login', LoginController::class)->name('login');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/posts', [ItemsController::class,'index']);
Route::get('/posts/{item_id}', [ItemsController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', LogoutController::class)->name('logout');

    Route::get('user', function (Request $request) {
        return $request->user();
    });

    Route::get('/users/me ', [UsersController::class, 'show']);  

    Route::get('test', function () {
        return response()->json(['message' => 'This is a protected route!']);
    });

    Route::post('/users/posts/new', [ItemsController::class, 'create']);

    Route::put('/users/posts/{item_id}/edit', [ItemsController::class, 'update']);
   
    Route::delete('/posts/{item_id}', [ItemsController::class, 'destroy']);
});