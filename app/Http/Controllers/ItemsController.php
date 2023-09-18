<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Categories;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $items =Items::all();

    return response()->json($items);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

         // 現在のログインユーザーを取得
        $user = auth()->user();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'production_time_per_minutes' => 'integer|nullable',
        ]);

        $item = new Items;
        $item->user_id = $user->id;
        $item->title = $request->input('title');
        $item->category_id = $request->input('category_id');
        $item->description = $request->input('description');
        $item->reference_url = $request->input('reference_url');
        $item->memo = $request->input('memo');
        $item->production_time_per_minutes = $request->input('production_time_per_minutes');



        if($request->hasFile('image_url')){
            $image = $request->file('image_url');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image_url'),$filename);

            $item->image_url = 'image_url/' . $filename;
        }
        $item->save();

        return response()->json(['message' => 'Item created successfully']);

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
    public function show($item_id)
    {
       // 特定のアイテムをデータベースから取得
    // $item = Items::find($item_id);
    $item = Items::with(['category', 'user'])->find($item_id);

    //  // $item の内容を確認
    // dd($item);

     if (!$item) {
        // アイテムが見つからない場合、適切なエラーレスポンスを返す（例: 404 Not Found）
        return response()->json(['message' => 'アイテムが見つかりません'], 404);
    }

    // アイテムデータをJSON形式でレスポンスとして返す
    return response()->json($item);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user_id, $item_id)
    {
      
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $item_id)
    {
     // 現在のログインユーザーを取得
        $user = auth()->user();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'production_time_per_minutes' => 'integer|nullable',
        ]);

        $item = Items::findOrFail($item_id);

        // Check if item belongs to the given user
        if ($item->user_id != $user->id) {
            return response()->json(['message' => 'Permission denied'], 403);
        }

        $item->title = $request->input('title');
        $item->category_id = $request->input('category_id');
        $item->description = $request->input('description');
        $item->reference_url = $request->input('reference_url');
        $item->memo = $request->input('memo');
        $item->production_time_per_minutes = $request->input('production_time_per_minutes');

        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image_url'), $filename);

            $item->image_url = 'image_url/' . $filename;
        }
        $item->save();

        return response()->json(['message' => 'Item updated successfully']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($item_id, Request $request)
    {
        $item = Items::findOrFail($item_id);

        if($item->user_id !== $request->user()->id){
            return response()->json(['error' => 'Unauthorized action'],403);
        }
        $item->delete();

        return response()->json(['message'=> 'Post deleted successfully']);
    }
}

