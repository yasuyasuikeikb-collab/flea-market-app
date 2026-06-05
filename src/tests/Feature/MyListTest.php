<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_liked_items_are_displayed_in_mylist(): void
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $likedItemId = DB::table('items')->insertGetId([
            'user_id' => $seller->id,
            'name' => 'いいねした商品',
            'price' => 1000,
            'brand_name' => 'テストブランド',
            'description' => 'いいねした商品です',
            'image_path' => 'items/liked.jpg',
            'condition' => '良好',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('items')->insert([
            'user_id' => $seller->id,
            'name' => 'いいねしていない商品',
            'price' => 2000,
            'brand_name' => 'テストブランド',
            'description' => 'いいねしていない商品です',
            'image_path' => 'items/not-liked.jpg',
            'condition' => '良好',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('likes')->insert([
            'user_id' => $user->id,
            'item_id' => $likedItemId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('いいねした商品');
        $response->assertDontSee('いいねしていない商品');
    }

    public function test_sold_item_is_displayed_with_sold_label_in_mylist(): void
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $itemId = DB::table('items')->insertGetId([
            'user_id' => $seller->id,
            'name' => '購入済みのいいね商品',
            'price' => 3000,
            'brand_name' => 'テストブランド',
            'description' => '購入済みの商品です',
            'image_path' => 'items/sold-liked.jpg',
            'condition' => '良好',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('likes')->insert([
            'user_id' => $user->id,
            'item_id' => $itemId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('purchases')->insert([
            'user_id' => $user->id,
            'item_id' => $itemId,
            'payment_method' => 'カード支払い',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
            'purchased_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('購入済みのいいね商品');
        $response->assertSee('Sold');
    }

    public function test_guest_user_cannot_see_any_items_in_mylist(): void
    {
        $seller = User::factory()->create();

        DB::table('items')->insert([
            'user_id' => $seller->id,
            'name' => 'ゲストには表示されない商品',
            'price' => 4000,
            'brand_name' => 'テストブランド',
            'description' => 'ゲストには表示されない商品です',
            'image_path' => 'items/guest-hidden.jpg',
            'condition' => '良好',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertDontSee('ゲストには表示されない商品');
    }
}