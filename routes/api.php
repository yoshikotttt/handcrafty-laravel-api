<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ItemsController;

Route::post('/login', LoginController::class)->name('login');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', LogoutController::class)->name('logout');

    Route::get('user', function (Request $request) {
        return $request->user();
    });

    Route::get('test', function () {
        return response()->json(['message' => 'This is a protected route!']);
    });

    Route::post('/users/{user_id}/posts/new', [ItemsController::class, 'create']);
});