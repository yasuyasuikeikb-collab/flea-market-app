<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellRequest;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class SellController extends Controller
{
    public function create()
    {
        $categories = Category::all();

        return view('sell.create', compact('categories'));
    }

    public function store(SellRequest $request)
    {
        $imagePath = $request->file('image')->store('items', 'public');

        $item = Item::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'brand_name' => $request->brand_name,
            'description' => $request->description,
            'price' => $request->price,
            'condition' => $request->condition,
            'image_path' => $imagePath,
        ]);

        $item->categories()->attach($request->categories);

        return redirect()->route('items.index')->with('success', '商品を出品しました');
    }
}