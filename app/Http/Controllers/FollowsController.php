<?php

namespace App\Http\Controllers;

use App\Models\Follows;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create($user_id)
    {
        $follower = auth()->user(); // 認証済みユーザーを取得

        // 既にフォローしているか確認
        $existingFollow = Follows::where('from_user_id', $follower->id)
            ->where('to_user_id', $user_id)
            ->first();

        if ($existingFollow) {
            return response()->json(['message' => '既にフォローしています'], 409); // 409: Conflict
        }

        // follows テーブルにデータを保存
        $follow = new Follows();
        $follow->from_user_id = $follower->id;
        $follow->to_user_id = $user_id;

        if ($follow->save()) {
            return response()->json(['message' => 'フォローしました'], 201); // 201: Created
        } else {
            return response()->json(['message' => 'フォローに失敗しました'], 500); // 500: Internal Server Error
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function check($user_id)
    {
        $follower = auth()->user();

        // 既にフォローしているか確認
        $existingFollow = Follows::where('from_user_id', $follower->id)
            ->where('to_user_id', $user_id)
            ->first();

        if ($existingFollow) {
            return response()->json(['isFollowing' => true]);
        } else {
            return response()->json(['isFollowing' => false]);
        }
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
    public function destroy($user_id)

    {
        $follower = auth()->user();

        // 既にフォローしているか確認
        $existingFollow = Follows::where('from_user_id', $follower->id)
            ->where('to_user_id', $user_id)
            ->first();

        if (!$existingFollow) {
            return response()->json(['message' => 'Follow relationship not found'], 404);
        }
        $existingFollow->delete();
        return response()->json(['message' => 'Follow removed successfully']);


    }
}
