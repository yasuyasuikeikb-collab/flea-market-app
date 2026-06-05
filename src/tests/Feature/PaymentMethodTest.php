<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    private function createItem(User $seller, string $name = '支払い方法確認商品'): int
    {
        return DB::table('items')->insertGetId([
            'user_id' => $seller->id,
            'name' => $name,
            'price' => 3000,
            'brand_name' => 'テストブランド',
            'description' => '支払い方法確認用の商品です',
            'image_path' => 'items/payment-test.jpg',
            'condition' => '良好',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_purchase_page_displays_payment_method_options(): void
    {
        $buyer = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $seller = User::factory()->create();
        $itemId = $this->createItem($seller);

        $response = $this->actingAs($buyer)->get('/purchase/' . $itemId);

        $response->assertStatus(200);
        $response->assertSee('支払い方法');
        $response->assertSee('選択してください');
        $response->assertSee('コンビニ払い');
        $response->assertSee('カード支払い');
    }

    public function test_selected_payment_method_is_saved_when_purchasing(): void
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        $itemId = $this->createItem($seller);

        $response = $this->actingAs($buyer)->post('/purchase/' . $itemId, [
            'payment_method' => 'コンビニ払い',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'item_id' => $itemId,
            'payment_method' => 'コンビニ払い',
        ]);

        $response->assertRedirect('/');
    }

    public function test_card_payment_method_is_saved_when_purchasing(): void
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        $itemId = $this->createItem($seller, 'カード支払い確認商品');

        $response = $this->actingAs($buyer)->post('/purchase/' . $itemId, [
            'payment_method' => 'カード支払い',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'item_id' => $itemId,
            'payment_method' => 'カード支払い',
        ]);

        $response->assertRedirect('/');
    }
}