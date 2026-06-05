<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_edit_page_displays_existing_user_information(): void
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'email_verified_at' => now(),
            'profile_image' => 'profiles/test-user.png',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区テスト町1-2-3',
            'building' => 'テストマンション101',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);

        $response->assertSee('storage/profiles/test-user.png', false);
        $response->assertSee('value="テストユーザー"', false);
        $response->assertSee('value="123-4567"', false);
        $response->assertSee('value="東京都渋谷区テスト町1-2-3"', false);
        $response->assertSee('value="テストマンション101"', false);
    }
}