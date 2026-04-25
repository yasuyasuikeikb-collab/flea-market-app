<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class PurchaseAddressController extends Controller
{
    public function edit($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        return view('purchase.address', compact('item', 'user'));
    }

    public function update(AddressRequest $request, $item_id)
    {
        session([
            'purchase_address_' . $item_id => [
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ]
        ]);

        return redirect()->route('purchase.create', ['item_id' => $item_id]);
    }
}