<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SellTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_item_with_required_information(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'email_verified_at' => now(),
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

        $image = UploadedFile::fake()->create('sell-test.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($user)->post('/sell', [
            'image' => $image,
            'categories' => [$categoryId1, $categoryId2],
            'condition' => '良好',
            'name' => '出品テスト商品',
            'brand_name' => 'テストブランド',
            'description' => 'これは出品テスト商品の説明です',
            'price' => 5000,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => '出品テスト商品',
            'brand_name' => 'テストブランド',
            'description' => 'これは出品テスト商品の説明です',
            'price' => 5000,
            'condition' => '良好',
        ]);

        $itemId = DB::table('items')
            ->where('name', '出品テスト商品')
            ->value('id');

        $this->assertDatabaseHas('category_item', [
            'item_id' => $itemId,
            'category_id' => $categoryId1,
        ]);

        $this->assertDatabaseHas('category_item', [
            'item_id' => $itemId,
            'category_id' => $categoryId2,
        ]);

        $imagePath = DB::table('items')
            ->where('id', $itemId)
            ->value('image_path');

        Storage::disk('public')->assertExists($imagePath);
    }
}