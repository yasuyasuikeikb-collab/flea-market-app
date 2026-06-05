<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_items_can_be_searched_by_partial_item_name(): void
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

        $response = $this->get('/?keyword=時計');

        $response->assertStatus(200);
        $response->assertSee('腕時計');
        $response->assertDontSee('HDD');
    }

    public function test_search_keyword_is_kept_when_moving_to_mylist(): void
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $likedItemId = DB::table('items')->insertGetId([
            'user_id' => $seller->id,
            'name' => '腕時計',
            'price' => 15000,
            'brand_name' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'image_path' => 'items/watch.jpg',
            'condition' => '良好',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('items')->insert([
            'user_id' => $seller->id,
            'name' => 'HDD',
            'price' => 5000,
            'brand_name' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'image_path' => 'items/hdd.jpg',
            'condition' => '目立った傷や汚れなし',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('likes')->insert([
            'user_id' => $user->id,
            'item_id' => $likedItemId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist&keyword=時計');

        $response->assertStatus(200);
        $response->assertSee('腕時計');
        $response->assertDontSee('HDD');
        $response->assertSee('value="時計"', false);
    }
}