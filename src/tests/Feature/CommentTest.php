<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    private function createItem(User $seller, string $name = 'コメント対象商品'): int
    {
        return DB::table('items')->insertGetId([
            'user_id' => $seller->id,
            'name' => $name,
            'price' => 1000,
            'brand_name' => 'テストブランド',
            'description' => 'コメント機能テスト用の商品です',
            'image_path' => 'items/comment-test.jpg',
            'condition' => '良好',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_authenticated_user_can_post_comment(): void
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();
        $itemId = $this->createItem($seller);

        $response = $this->actingAs($user)->post('/item/' . $itemId . '/comment', [
            'content' => '購入を検討しています',
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $itemId,
            'content' => '購入を検討しています',
        ]);

        $response->assertRedirect();

        $detailResponse = $this->get('/item/' . $itemId);

        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('コメント(1)');
        $detailResponse->assertSee('購入を検討しています');
        $detailResponse->assertSee($user->name);
    }

    public function test_guest_user_cannot_post_comment(): void
    {
        $seller = User::factory()->create();
        $itemId = $this->createItem($seller);

        $response = $this->post('/item/' . $itemId . '/comment', [
            'content' => 'ログイン前のコメントです',
        ]);

        $this->assertDatabaseMissing('comments', [
            'item_id' => $itemId,
            'content' => 'ログイン前のコメントです',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_comment_content_is_required(): void
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();
        $itemId = $this->createItem($seller);

        $response = $this->actingAs($user)
            ->from('/item/' . $itemId)
            ->post('/item/' . $itemId . '/comment', [
                'content' => '',
            ]);

        $response->assertRedirect('/item/' . $itemId);

        $response->assertSessionHasErrors([
            'content' => 'コメントを入力してください',
        ]);

        $this->assertDatabaseCount('comments', 0);
    }

    public function test_comment_content_must_be_255_characters_or_less(): void
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();
        $itemId = $this->createItem($seller);

        $response = $this->actingAs($user)
            ->from('/item/' . $itemId)
            ->post('/item/' . $itemId . '/comment', [
                'content' => str_repeat('あ', 256),
            ]);

        $response->assertRedirect('/item/' . $itemId);

        $response->assertSessionHasErrors([
            'content' => 'コメントは255文字以内で入力してください',
        ]);

        $this->assertDatabaseCount('comments', 0);
    }
}