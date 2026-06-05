<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_detail_page_displays_required_information(): void
    {
        $seller = User::factory()->create([
            'name' => '出品者',
        ]);

        $commentUser = User::factory()->create([
            'name' => 'コメントユーザー',
        ]);

        $likeUser1 = User::factory()->create();
        $likeUser2 = User::factory()->create();

        $itemId = DB::table('items')->insertGetId([
            'user_id' => $seller->id,
            'name' => '腕時計',
            'price' => 12000,
            'brand_name' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計です',
            'image_path' => 'items/watch.jpg',
            'condition' => '良好',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $categoryId = DB::table('categories')->insertGetId([
            'name' => 'ファッション',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('category_item')->insert([
            'item_id' => $itemId,
            'category_id' => $categoryId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('likes')->insert([
            [
                'user_id' => $likeUser1->id,
                'item_id' => $itemId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $likeUser2->id,
                'item_id' => $itemId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('comments')->insert([
            'user_id' => $commentUser->id,
            'item_id' => $itemId,
            'content' => 'こちらの商品は購入可能ですか？',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->get('/item/' . $itemId);

        $response->assertStatus(200);

        $response->assertSee('腕時計');
        $response->assertSee('Rolax');
        $response->assertSee('¥12,000');
        $response->assertSee('スタイリッシュなデザインのメンズ腕時計です');
        $response->assertSee('ファッション');
        $response->assertSee('良好');
        $response->assertSee('コメント(1)');
        $response->assertSee('コメントユーザー');
        $response->assertSee('こちらの商品は購入可能ですか？');

        $response->assertSee('storage/items/watch.jpg', false);
    }

    public function test_multiple_categories_are_displayed_on_item_detail_page(): void
    {
        $seller = User::factory()->create();

        $itemId = DB::table('items')->insertGetId([
            'user_id' => $seller->id,
            'name' => 'カテゴリ複数商品',
            'price' => 5000,
            'brand_name' => 'テストブランド',
            'description' => '複数カテゴリの商品です',
            'image_path' => 'items/category.jpg',
            'condition' => '目立った傷や汚れなし',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $categoryId1 = DB::table('categories')->insertGetId([
            'name' => 'ファッション',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $categoryId2 = DB::table('categories')->insertGetId([
            'name' => 'メンズ',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $categoryId3 = DB::table('categories')->insertGetId([
            'name' => 'アクセサリー',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('category_item')->insert([
            [
                'item_id' => $itemId,
                'category_id' => $categoryId1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_id' => $itemId,
                'category_id' => $categoryId2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_id' => $itemId,
                'category_id' => $categoryId3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $response = $this->get('/item/' . $itemId);

        $response->assertStatus(200);
        $response->assertSee('カテゴリ複数商品');
        $response->assertSee('ファッション');
        $response->assertSee('メンズ');
        $response->assertSee('アクセサリー');
    }
}