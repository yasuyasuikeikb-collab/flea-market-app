<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_items_are_displayed(): void
    {
        $seller = User::factory()->create();

        DB::table('items')->insert([
            [
                'user_id' => $seller->id,
                'name' => '腕時計',
                'price' => 15000,
                'brand_name' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'image_path' => 'items/watch.jpg',
                'condition' => '良好',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $seller->id,
                'name' => 'HDD',
                'price' => 5000,
                'brand_name' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'image_path' => 'items/hdd.jpg',
                'condition' => '目立った傷や汚れなし',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('腕時計');
        $response->assertSee('HDD');
    }

    public function test_sold_item_is_displayed_with_sold_label(): void
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();

        $itemId = DB::table('items')->insertGetId([
            'user_id' => $seller->id,
            'name' => '購入済み商品',
            'price' => 3000,
            'brand_name' => 'テストブランド',
            'description' => '購入済みの商品です',
            'image_path' => 'items/sold.jpg',
            'condition' => '良好',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

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
        $response->assertSee('購入済み商品');
        $response->assertSee('Sold');
    }

    public function test_own_items_are_not_displayed_when_logged_in(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        DB::table('items')->insert([
            [
                'user_id' => $user->id,
                'name' => '自分の商品',
                'price' => 1000,
                'brand_name' => '自分ブランド',
                'description' => '自分が出品した商品です',
                'image_path' => 'items/my-item.jpg',
                'condition' => '良好',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $otherUser->id,
                'name' => '他人の商品',
                'price' => 2000,
                'brand_name' => '他人ブランド',
                'description' => '他人が出品した商品です',
                'image_path' => 'items/other-item.jpg',
                'condition' => '良好',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('自分の商品');
        $response->assertSee('他人の商品');
    }
}