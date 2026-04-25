<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function create($item_id)
    {
        $item = Item::with('purchase')->findOrFail($item_id);
        $user = Auth::user();

        return view('purchase.create', compact('item', 'user'));
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        $item = Item::with('purchase')->findOrFail($item_id);

        if ($item->purchase) {
            return redirect()->route('items.show', ['item_id' => $item_id])
                ->with('error', 'この商品はすでに購入されています');
        }

        Purchase::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'payment_method' => $request->payment_method,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
            'purchased_at' => now(),
        ]);

        return redirect()->route('items.index')->with('success', '購入が完了しました');
    }
}