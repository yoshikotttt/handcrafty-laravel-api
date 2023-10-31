<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        // 通知の取得ロジック
        $user = auth()->user(); // 認証ユーザーを取得

        $notifications = Requests::where(function ($query) use ($user) {
            $query->where('to_user_id', $user->id)
                ->where('status', 0);
        })
            ->orWhere(function ($query) use ($user) {
                $query->where('from_user_id', $user->id)
                    ->whereIn('status', [2, 3]);
            })
            ->get();

        return response()->json (['notifications' => $notifications]);
    }

}
