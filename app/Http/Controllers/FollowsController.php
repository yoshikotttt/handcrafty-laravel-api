<?php

namespace App\Http\Controllers;

use App\Models\Follows;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


    public function myFollowers()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $user = Auth::user();
        $followers = $user->followers;

        if ($followers->isEmpty()) {
            return response()->json(['message' => 'No followers found'], 404);
        }

        return response()->json($followers);
    }

    public function myFollowing()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $user = Auth::user();
        $following = $user->following;

        if ($following->isEmpty()) {
            return response()->json(['message' => 'No following users found'], 404);
        }

        return response()->json($following);
    }

    public function followers($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $followers = $user->followers;

        if ($followers->isEmpty()) {
            return response()->json(['message' => 'This user has no followers'], 404);
        }

        return response()->json($followers);
    }

    public function following($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $following = $user->following;

        if ($following->isEmpty()) {
            return response()->json(['message' => 'This user is not following anyone'], 404);
        }

        return response()->json($following);
    }
}
