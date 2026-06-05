<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    private function createItem(User $seller, string $name = 'テスト商品'): int
    {
        return DB::table('items')->insertGetId([
            'user_id' => $seller->id,
            'name' => $name,
            'price' => 1000,
            'brand_name' => 'テストブランド',
            'description' => 'テスト商品の説明です',
            'image_path' => 'items/test.jpg',
            'condition' => '良好',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_authenticated_user_can_like_item(): void
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();
        $itemId = $this->createItem($seller);

        $response = $this->actingAs($user)->post('/item/' . $itemId . '/like');

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $itemId,
        ]);

        $response->assertRedirect();
    }

    public function test_liked_item_displays_active_like_icon_and_like_count(): void
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();
        $itemId = $this->createItem($seller);

        DB::table('likes')->insert([
            'user_id' => $user->id,
            'item_id' => $itemId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/item/' . $itemId);

        $response->assertStatus(200);
        $response->assertSee('icon-heart-active.png', false);
        $response->assertSee('<p class="item-detail__action-count">1</p>', false);
    }

    public function test_authenticated_user_can_unlike_item(): void
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();
        $itemId = $this->createItem($seller);

        DB::table('likes')->insert([
            'user_id' => $user->id,
            'item_id' => $itemId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($user)->delete('/item/' . $itemId . '/like');

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $itemId,
        ]);

        $response->assertRedirect();

        $detailResponse = $this->actingAs($user)->get('/item/' . $itemId);

        $detailResponse->assertStatus(200);
        $detailResponse->assertDontSee('icon-heart-active.png', false);
        $detailResponse->assertSee('icon-heart.png', false);
        $detailResponse->assertSee('<p class="item-detail__action-count">0</p>', false);
    }
}