<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class LoginController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        // リクエストからemailとpasswordの値を取得
        $credentials = $request->only(['email', 'password']);

        // 認証開始
        if (Auth::attempt($credentials)) {
            $user = Auth::user();


            
            $token = $user->createToken('MyAppToken')->plainTextToken;

            // レスポンスを返す
            return new JsonResponse([
                'message' => 'Authenticated.',
                'token' => $token,
                'user' => $user
            ]);
        }

        // 認証エラーが発生した場合に例外を投げる
        throw new AuthenticationException();
    }
}