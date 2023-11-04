<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use App\Models\User;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $roomId)
    {
        // $ids = explode('_', $roomId);
        // if (count($ids) != 2) {
        //     return response()->json(['error' => '無効なroomIdフォーマット'], 400);
        // }
        // list($userID1, $userID2) = $ids;

        list($userID1, $userID2) = explode('_', $roomId);

        $currentUserId = auth()->id();

        if ($currentUserId != $userID1 && $currentUserId != $userID2) {
            return response()->json(['error' => 'アクセス権限がありません'], 403);
        }

        $messages = Messages::with(['fromUser', 'toUser'])
            ->where(function ($query) use ($userID1, $userID2) {
                $query->where('from_user_id', $userID1)
                    ->orWhere('from_user_id', $userID2);
            })
            ->where(function ($query) use ($userID1, $userID2) {
                $query->where('to_user_id', $userID1)
                    ->orWhere('to_user_id', $userID2);
            })
            ->get();

        return response()->json($messages);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $roomId)
    {
        
        // $ids = explode('_', $roomId);
        // if (count($ids) != 2) {
        //     return response()->json(['error' => '無効なroomIdフォーマット'], 400);
        // }
        // list($userID1, $userID2) = $ids;

        list($userID1, $userID2) = explode('_', $roomId);

        $loggedInUserId = auth()->id();

        $recipientId = ($loggedInUserId == $userID1) ? $userID2 : $userID1;

        $message = new Messages();
        $message->from_user_id = $loggedInUserId;
        $message->to_user_id = $recipientId;
        $message->body = $request->input('message'); // 'content'を'message'に変更
        $message->save();

        return response()->json(['message' => 'メッセージが保存されました']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    // public function chatUsersList()
    // {
    //     $loginUserId = auth()->id();

    //     $chatUsers = Messages::with(['fromUser', 'toUser'])
    //     ->selectRaw('CASE WHEN from_user_id = ? THEN to_user_id ELSE from_user_id END as user_id', [$loginUserId])
    //         ->where(function ($query) use ($loginUserId) {
    //             $query->where('from_user_id', $loginUserId)
    //                 ->orWhere('to_user_id', $loginUserId);
    //         })
    //         ->distinct()
    //         ->orderBy('user_id')
    //         ->get();

    //     return response()->json($chatUsers);
    // }

    public function chatUsersList()
    {
        $loginUserId = auth()->id();

        // まず、ログインユーザーとチャットがあるユーザーIDのユニークなリストを取得します。
        $chatUserIds = Messages::selectRaw('CASE WHEN from_user_id = ? THEN to_user_id ELSE from_user_id END as user_id', [$loginUserId])
            ->where('from_user_id', $loginUserId)
            ->orWhere('to_user_id', $loginUserId)
            ->distinct()
            ->pluck('user_id');

        // 取得したIDのユーザーを一度に読み込みます。
        $chatUsers = User::whereIn('id', $chatUserIds)
            ->get();

        return response()->json($chatUsers);
    }


}
