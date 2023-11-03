<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {

        $user = auth()->user(); // 認証ユーザーを取得

        $notifications = Requests::with(['fromUser', 'toUser'])
            ->where(function ($query) use ($user) {
                $query->where('to_user_id', $user->id)
                    ->where(
                        'status',
                        0
                    );
            })
            ->orWhere(function ($query) use ($user) {
                $query->where('from_user_id', $user->id)
                    ->whereIn('status', [2, 3]);
            })
            ->get();


        return response()->json(['notifications' => $notifications]);
    }

    public function getAllNotifications()
    {
        $user = auth()->user(); // 認証ユーザーを取得

        $notifications = Requests::with(['fromUser', 'toUser'])
        ->where(function ($query) use ($user) {
            $query->where('to_user_id', $user->id)
                ->orWhere('from_user_id', $user->id);
        })
            ->get();

        return response()->json([
            'notifications' => $notifications,
            'currentUserId' => $user->id
        ]);

    }

    public function getUnreadNotificationsCount()
    {
        $user = auth()->user(); // 認証ユーザーを取得

        $count = Requests::where('to_user_id', $user->id)
            ->where('status', 0)
            ->count();

        return response()->json(['unreadCount' => $count]);
    }



    public function show($id)
    {
        // 現在の認証ユーザーIDを取得
        $currentUserId = auth()->id();

        // 指定されたIDの通知を取得し、to_user_id または from_user_id が現在のユーザーIDと一致するもののみを対象とする
        $notification = Requests::with(['toUser','fromUser'])
            ->where('id', $id)
            ->where(function ($query) use ($currentUserId) {
                $query->where('to_user_id', $currentUserId)
                    ->orWhere('from_user_id', $currentUserId);
            })
            ->firstOrFail();

        // 通知を返す
        return response()->json($notification);
    }


    public function update(Request $request, $id)
    {
        $notification = Requests::findOrFail($id);

        // リクエストデータのバリデーション（必要に応じて）

        // リクエストから送信されたデータで通知を更新
        $notification->update($request->all());

        return response()->json($notification);
    }


}
