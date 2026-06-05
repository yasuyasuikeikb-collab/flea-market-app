<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    private function createItem(User $seller, string $name = '購入対象商品'): int
    {
        return DB::table('items')->insertGetId([
            'user_id' => $seller->id,
            'name' => $name,
            'price' => 3000,
            'brand_name' => 'テストブランド',
            'description' => '購入機能テスト用の商品です',
            'image_path' => 'items/purchase-test.jpg',
            'condition' => '良好',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_authenticated_user_can_purchase_item(): void
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        $itemId = $this->createItem($seller);

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
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $response->assertRedirect('/');
    }

    public function test_purchased_item_is_displayed_as_sold_on_item_index(): void
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        $itemId = $this->createItem($seller, 'Sold表示確認商品');

        DB::table('purchases')->insert([
            'user_id' => $buyer->id,
            'item_id' => $itemId,
            'payment_method' => 'カード支払い',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
            'purchased_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sold表示確認商品');
        $response->assertSee('Sold');
    }

    public function test_purchased_item_is_displayed_on_mypage_purchase_list(): void
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        $itemId = $this->createItem($seller, '購入一覧表示商品');

        DB::table('purchases')->insert([
            'user_id' => $buyer->id,
            'item_id' => $itemId,
            'payment_method' => 'カード支払い',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
            'purchased_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($buyer)->get('/mypage?page=buy');

        $response->assertStatus(200);
        $response->assertSee('購入一覧表示商品');
    }
}