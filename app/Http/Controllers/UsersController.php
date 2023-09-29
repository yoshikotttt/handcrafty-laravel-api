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
    public function getMyProfile()
    {
        $user = Auth::user();

        $items = Items::where('user_id',$user->id)->get();

        if ($items->isEmpty()) {
        // アイテムが見つからない場合、適切なエラーレスポンスを返す（例: 404 Not Found）
        return response()->json(['message' => 'アイテムが見つかりません'], 404);
    }

        // アイテムとユーザーデータをJSON形式でレスポンスとして返す
        return response()->json([
            'user' => $user, // ログインしているユーザーの情報
            'items' => $items // そのユーザーのアイテム情報
        ]);
    }

    public function getUserProfile($user_id)
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

        // アイテムとユーザーデータをJSON形式でレスポンスとして返す
        return response()->json([
            'user' => $user, // ログインしているユーザーの情報
            'items' => $items // そのユーザーのアイテム情報
        ]);
    }
        
    }

    
 


