<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MyPageTest extends TestCase
{
    use RefreshDatabase;

    private function createItem(User $seller, string $name, string $imagePath = 'items/test.jpg'): int
    {
        return DB::table('items')->insertGetId([
            'user_id' => $seller->id,
            'name' => $name,
            'price' => 3000,
            'brand_name' => 'テストブランド',
            'description' => $name . 'の説明です',
            'image_path' => $imagePath,
            'condition' => '良好',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_mypage_displays_user_profile_image_and_name(): void
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'profile_image' => 'profiles/user1.png',
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('storage/profiles/user1.png', false);
    }

    public function test_mypage_displays_items_listed_by_user(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $this->createItem($user, '自分が出品した商品', 'items/my-sell-item.jpg');
        $this->createItem($otherUser, '他人が出品した商品', 'items/other-sell-item.jpg');

        $response = $this->actingAs($user)->get('/mypage?page=sell');

        $response->assertStatus(200);
        $response->assertSee('自分が出品した商品');
        $response->assertDontSee('他人が出品した商品');
    }

    public function test_mypage_displays_items_purchased_by_user(): void
    {
        $buyer = User::factory()->create();
        $otherBuyer = User::factory()->create();
        $seller = User::factory()->create();

        $purchasedItemId = $this->createItem($seller, '自分が購入した商品', 'items/my-buy-item.jpg');
        $otherPurchasedItemId = $this->createItem($seller, '他人が購入した商品', 'items/other-buy-item.jpg');

        DB::table('purchases')->insert([
            [
                'user_id' => $buyer->id,
                'item_id' => $purchasedItemId,
                'payment_method' => 'カード支払い',
                'postal_code' => '123-4567',
                'address' => '東京都渋谷区',
                'building' => 'テストビル101',
                'purchased_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $otherBuyer->id,
                'item_id' => $otherPurchasedItemId,
                'payment_method' => 'カード支払い',
                'postal_code' => '765-4321',
                'address' => '大阪府大阪市',
                'building' => '別ビル202',
                'purchased_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $response = $this->actingAs($buyer)->get('/mypage?page=buy');

        $response->assertStatus(200);
        $response->assertSee('自分が購入した商品');
        $response->assertDontSee('他人が購入した商品');
    }
}