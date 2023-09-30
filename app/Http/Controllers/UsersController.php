<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'bio'  => 'nullable|string|max:500',
            'avatar_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // avatar_url（画像）があれば、保存してそのURLを取得
        if($request->hasFile('avatar_url')){
            $avatar_url = $request->file('avatar_url');
            $filename = time() . '_' . $avatar_url->getClientOriginalName();
            $avatar_url->move(public_path('avatar_url'), $filename);
            $validatedData['avatar_url'] = 'avatar_url/' . $filename;
            }

        $user->update($validatedData);


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

        if ($items->isEmpty()) {
            // アイテムが見つからない
            return response()->json(['message' => 'アイテムが見つかりません'], 404);
        }

        //投稿数
        $postsCount = $user->items()->count();
        //フォロワー
        $followersCount = $user->follows()->where('to_user_id', $user->id)->count();
        //フォロー中
        $followingCount = $user->follows()->where('from_user_id', $user->id)->count();

        

        // アイテムとユーザーデータをJSON形式でレスポンスとして返す
        return response()->json([
            'user' => $user, // ログインしているユーザーの情報
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

        // アイテムが見つからない
        if ($items->isEmpty()) {
            return response()->json(['message' => 'アイテムが見つかりません'], 404);
        }

        //投稿数
        $postsCount = $user->items()->count();
        //フォロワー
        $followersCount = $user->follows()->where('to_user_id',$user->id)->count();
        //フォロー中
        $followingCount = $user->follows()->where('from_user_id', $user->id)->count();

       

        // アイテムとユーザーデータをJSON形式でレスポンスとして返す
        return response()->json([
            'user' => $user, // ログインしているユーザーの情報
            'items' => $items, // そのユーザーのアイテム情報
            'isOwnProfile' => false,  // 他のユーザーのプロフィールページであることを示すフラグ
            'postsCount' => $postsCount,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount
        ]);
    }
}
