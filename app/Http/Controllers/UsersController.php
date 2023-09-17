<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;

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
    public function show($user_id)
    {
        $items = Items::where('user_id',$user_id)->get();

        if ($items->isEmpty()) {
        // アイテムが見つからない場合、適切なエラーレスポンスを返す（例: 404 Not Found）
        return response()->json(['message' => 'アイテムが見つかりません'], 404);
    }

    // アイテムデータをJSON形式でレスポンスとして返す
    return response()->json($items);
    }
        
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
}
