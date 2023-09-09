<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class LogoutController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        // ユーザーが認証されていない場合
        if (!$request->user()) {
            return new JsonResponse([
                'message' => 'Already Unauthenticated.',
            ], 400);
        }

        // 現在のアクセストークンを削除することでログアウト
        $request->user()->currentAccessToken()->delete();

        return new JsonResponse([
            'message' => 'Unauthenticated.',
        ]);
    }
}