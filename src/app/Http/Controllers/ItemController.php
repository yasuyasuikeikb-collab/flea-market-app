<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab');
        $keyword = $request->query('keyword');

        if ($tab === 'mylist') {
            if (!Auth::check()) {
                $items = collect();
            } else {
                $items = Item::with(['purchase'])
                    ->whereHas('likes', function ($query) {
                        $query->where('user_id', Auth::id());
                    })
                    ->when($keyword, function ($query, $keyword) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    })
                    ->latest()
                    ->get();
            }
        } else {
            $items = Item::with(['purchase'])
                ->when(Auth::check(), function ($query) {
                    $query->where('user_id', '!=', Auth::id());
                })
                ->when($keyword, function ($query, $keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->latest()
                ->get();
        }

        return view('items.index', compact('items', 'tab', 'keyword'));
    }

    public function show($item_id)
    {
        $item = Item::with([
            'user',
            'categories',
            'comments.user',
            'likes',
            'purchase',
        ])->findOrFail($item_id);

        $likeCount = $item->likes->count();
        $commentCount = $item->comments->count();

        $isLiked = false;
        if (Auth::check()) {
            $isLiked = $item->likes()->where('user_id', Auth::id())->exists();
        }

        return view('items.show', compact('item', 'likeCount', 'commentCount', 'isLiked'));
    }
}