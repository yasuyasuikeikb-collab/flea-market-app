<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommentsTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('comments')->insert([
            [
                'user_id' => 2,
                'item_id' => 1,
                'content' => 'シンプルで使いやすそうですね。',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 3,
                'item_id' => 1,
                'content' => '電池の持ちはどのくらいですか？',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 1,
                'item_id' => 2,
                'content' => '付属品はすべて揃っていますか？',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 3,
                'item_id' => 5,
                'content' => '状態が良ければ購入したいです。',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}