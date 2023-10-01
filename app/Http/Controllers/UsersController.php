<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'avatar_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        // avatar_url（画像）があれば、保存してそのURLを取得
        if ($request->hasFile('avatar_url')) {
            $avatar_url = $request->file('avatar_url');
            $filename = time() . '_' . $avatar_url->getClientOriginalName();
            $avatar_url->move(public_path('avatar_url'), $filename);
            $data['avatar_url'] = 'avatar_url/' . $filename; // $data に新しい URL をセット
        }

        $user->update($data);

        return response()->json([
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }

   
    public function getProfileEditData()
    {
        $user = Auth::user();

        // 認証されていない場合のエラーチェック
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);  // 401は「Unauthorized」のHTTPステータスコード
        }

        return response()->json($user);
    }

  
    public function myProfile()
    {
        $user = Auth::user();

        $items = Items::where('user_id', $user->id)->get();

        // 投稿数
        $postsCount = $user->items()->count();
        // フォロワー数
        $followersCount = $user->followers->count();
        // フォロー中の数
        $followingCount = $user->following->count();


        

        // アイテムとユーザーデータをJSON形式でレスポンスとして返す
        return response()->json([
            'user' => $user, // ユーザーの情報
            'items' => $items, // そのユーザーのアイテム情報
            'isOwnProfile' => true,  // 自分のプロフィールページであることを示すフラグ
            'postsCount' => $postsCount,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount
        ]);
    }

    public function getProfile($user_id)
    {
        $user = User::find($user_id);
        // Log::info($user);


        //ユーザーが見つからない
        if (!$user) {
            return response()->json(['message' => 'ユーザーが見つかりません'], 404);
        }

        $items = Items::where('user_id', $user->id)->get();

        // 投稿数
        $postsCount = $user->items()->count();
        // フォロワー数
        $followersCount = $user->followers->count();
        // フォロー中の数
        $followingCount = $user->following->count();


       

        // アイテムとユーザーデータをJSON形式でレスポンスとして返す
        return response()->json([
            'user' => $user, // ユーザーの情報
            'items' => $items, // そのユーザーのアイテム情報
            'isOwnProfile' => false,  // 他のユーザーのプロフィールページであることを示すフラグ
            'postsCount' => $postsCount,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount
        ]);
    }
}
