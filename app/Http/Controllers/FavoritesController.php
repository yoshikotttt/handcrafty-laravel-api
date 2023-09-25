<?php

namespace App\Http\Controllers;

use App\Models\Favorites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FavoritesController extends Controller
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
        $user = Auth::user(); 
        // すでに「いいね」されているか確認
        $existingFavorite = Favorites::where('user_id', $user->id)->where('item_id', $item_id)->first();

        if ($existingFavorite) {
            return response()->json(['message' => 'Already favorite']);
        }

        $favorite = new Favorites();
        $favorite->user_id = $user->id;
        $favorite->item_id = $item_id;


        $favorite->save();

        return response()->json(['message' => 'success']);
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
    public function check($item_id)
    {
        $user = Auth::user(); 

        $existingFavorite = Favorites::where('user_id', $user->id)->where('item_id', $item_id)->first();

        if ($existingFavorite) {
            return response()->json(['isFavorite' => true]);
        } else {
            return response()->json(['isFavorite' => false]);
        }
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
    public function destroy($item_id)
    {
        $user = auth()->user();

        $existingFavorite = Favorites::where('user_id', $user->id)->where('item_id', $item_id)->first();

        if (!$existingFavorite) {
            return response()->json(['message' => 'favorite not found'], 404);
        }
        $existingFavorite->delete();
        return response()->json(['message' => 'Favorite removed successfully']);
    }

    public function getAll()
    {
        $user = Auth::user();
        //    Log::info('Received request data:', ['data' => $user->id]);

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // ユーザーのお気に入りを取得
        // $favorites = $user-> favorites;
        $favorites = $user->favorites()->with('item')->get(); 
        return response()->json($favorites);
    }
}
