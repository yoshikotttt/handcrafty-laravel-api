<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LikesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($item_id)
    {

        // 現在のログインユーザーを取得
        $user = auth()->user();
        // すでに「いいね」されているか確認
        $existingLike = Likes::where('user_id', $user->id)->where('item_id', $item_id)->first();

        if ($existingLike) {
            return response()->json(['message' => 'Already liked']);
        }

        $like = new Likes();
        $like->user_id = $user->id;
        $like->item_id = $item_id;


        $like->save();

        return response()->json(['message' => 'success']);
    }


    public function check($item_id)
    {
        $user = auth()->user();

        $existingLike = Likes::where('user_id', $user->id)->where('item_id', $item_id)->first();

        if ($existingLike) {
            return response()->json(['isLiked' => true]);
        } else {
            return response()->json(['isLiked' => false]);
        }
    }

    public function destroy($item_id)
    {
        $user = auth()->user();

        $existingLike = Likes::where('user_id', $user->id)->where('item_id', $item_id)->first();

        if (!$existingLike) {
            return response()->json(['message' => 'like not found'], 404);
        }
        $existingLike->delete();
        return response()->json(['message' => 'Like removed successfully']);
    }

    public function info($item_id)
    {
        try {
            // いいねの総数を取得
            $likeCount = Likes::where('item_id', $item_id)->count();

            // 最初のいいねをしたユーザーの情報を取得
            $firstLiker = Likes::where('item_id', $item_id)
                ->orderBy('created_at', 'asc')
                ->with('user') // 前提: Likeモデルにuserリレーションがある
                ->first();

            // 必要に応じてデータの形式を整形
            $response = [
                'likeCount' => $likeCount,
                'firstLiker' => $firstLiker ? $firstLiker->user : null,
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data retrieval failed'], 500);
        }
    }

    public function getAll($item_id)
    {
        // item_idが受け取れているかの確認
        // Log::info('Received request data:', ['data' => $item_id]);
        try {
            // いいねの総数を取得
            $likes = Likes::where('item_id', $item_id)->with('user')->get();
          
          


            // $likesに値が入っているかどうかを確認する
            if (empty($likes)) {
                // 値が入っていない場合
                return response()->json(['error' => 'いいねがありません'], 404);
            } else {
                // 値が入っている場合
                $response = $likes->map(function ($like) {
                    return [
                        'user_id' => $like->user_id,
                        'user_name' => $like->user->name,
                    ];
                });
                return response()->json($response);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'データの取得に失敗しました'], 500);
        }
    }
}
