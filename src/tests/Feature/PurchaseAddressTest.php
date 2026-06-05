<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PurchaseAddressTest extends TestCase
{
    use RefreshDatabase;

    private function createItem(User $seller, string $name = '配送先変更確認商品'): int
    {
        return DB::table('items')->insertGetId([
            'user_id' => $seller->id,
            'name' => $name,
            'price' => 3000,
            'brand_name' => 'テストブランド',
            'description' => '配送先変更機能テスト用の商品です',
            'image_path' => 'items/address-test.jpg',
            'condition' => '良好',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_updated_shipping_address_is_displayed_on_purchase_page(): void
    {
        $buyer = User::factory()->create([
            'postal_code' => '111-1111',
            'address' => '変更前住所',
            'building' => '変更前建物',
        ]);

        $seller = User::factory()->create();

        $itemId = $this->createItem($seller);

        $response = $this->actingAs($buyer)->post('/purchase/address/' . $itemId, [
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区テスト町1-2-3',
            'building' => 'テストマンション101',
        ]);

        $response->assertRedirect('/purchase/' . $itemId);

        $purchasePageResponse = $this->actingAs($buyer)->get('/purchase/' . $itemId);

        $purchasePageResponse->assertStatus(200);
        $purchasePageResponse->assertSee('123-4567');
        $purchasePageResponse->assertSee('東京都渋谷区テスト町1-2-3');
        $purchasePageResponse->assertSee('テストマンション101');
    }

    public function test_purchase_is_saved_with_updated_shipping_address(): void
    {
        $buyer = User::factory()->create([
            'postal_code' => '111-1111',
            'address' => '変更前住所',
            'building' => '変更前建物',
        ]);

        $seller = User::factory()->create();

        $itemId = $this->createItem($seller, '配送先紐づけ確認商品');

        $this->actingAs($buyer)->post('/purchase/address/' . $itemId, [
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区テスト町1-2-3',
            'building' => 'テストマンション101',
        ]);

        $response = $this->actingAs($buyer)->post('/purchase/' . $itemId, [
            'payment_method' => 'カード支払い',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区テスト町1-2-3',
            'building' => 'テストマンション101',
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'item_id' => $itemId,
            'payment_method' => 'カード支払い',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区テスト町1-2-3',
            'building' => 'テストマンション101',
        ]);

        $response->assertRedirect('/');
    }
}