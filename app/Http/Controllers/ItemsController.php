<?php

namespace App\Http\Controllers;

use App\Models\Items;
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
    public function create(Request $request, $user_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ]);

        $item = new Items;
        $item->user_id = $user_id;
        $item->title = $request->input('title');
        $item->category_id = $request->input('category_id');
        $item->description = $request->input('description');

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
    public function show(Items $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Items $Items)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Items $books)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Items $Items)
    {
        //
    }
}

