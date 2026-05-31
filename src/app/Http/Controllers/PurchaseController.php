<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;

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

  public function checkout(PurchaseRequest $request, $item_id)
  {
    $item = Item::with('purchase')->findOrFail($item_id);

    if ($item->purchase) {
      return redirect()->route('items.show', ['item_id' => $item_id])
        ->with('error', 'この商品はすでに購入されています');
    }

    $paymentMethodType = match ($request->payment_method) {
      'カード支払い' => 'card',
      'コンビニ払い' => 'konbini',
      default => null,
    };

    if (!$paymentMethodType) {
      return back()
        ->withErrors(['payment_method' => '支払い方法を選択してください'])
        ->withInput();
    }

    session([
      'purchase_data_' . $item->id => [
        'payment_method' => $request->payment_method,
        'postal_code' => $request->postal_code,
        'address' => $request->address,
        'building' => $request->building,
      ],
    ]);

    $stripe = new StripeClient(config('services.stripe.secret'));

    $checkoutSession = $stripe->checkout->sessions->create([
      'payment_method_types' => [$paymentMethodType],
      'line_items' => [
        [
          'price_data' => [
            'currency' => 'jpy',
            'product_data' => [
              'name' => $item->name,
            ],
            'unit_amount' => $item->price,
          ],
          'quantity' => 1,
        ],
      ],
      'mode' => 'payment',
      'customer_email' => Auth::user()->email,
      'success_url' => route('purchase.success', ['item_id' => $item->id], true) . '?session_id={CHECKOUT_SESSION_ID}',
      'cancel_url' => route('purchase.cancel', ['item_id' => $item->id], true),
    ]);

    return redirect($checkoutSession->url);
  }

  public function success(Request $request, $item_id)
  {
    $item = Item::with('purchase')->findOrFail($item_id);

    if ($item->purchase) {
      return redirect()->route('items.show', ['item_id' => $item_id]);
    }

    $purchaseData = session('purchase_data_' . $item->id);

    if (!$purchaseData) {
      return redirect()->route('purchase.create', ['item_id' => $item_id])
        ->with('error', '購入情報が見つかりませんでした');
    }

    Purchase::create([
      'user_id' => Auth::id(),
      'item_id' => $item->id,
      'payment_method' => $purchaseData['payment_method'],
      'postal_code' => $purchaseData['postal_code'],
      'address' => $purchaseData['address'],
      'building' => $purchaseData['building'],
      'purchased_at' => now(),
    ]);

    session()->forget('purchase_data_' . $item->id);

    return redirect()->route('items.index')
      ->with('success', '購入が完了しました');
  }

  public function cancel($item_id)
  {
    return redirect()->route('purchase.create', ['item_id' => $item_id])
      ->with('error', '決済がキャンセルされました');
  }
}