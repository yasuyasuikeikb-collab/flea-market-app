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
                'content' => '文字盤のサイズ感が気になります。',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 3,
                'item_id' => 1,
                'content' => 'ベルトの状態は良さそうですね。',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 3,
                'item_id' => 2,
                'content' => '接続端子の種類を知りたいです。',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 2,
                'item_id' => 5,
                'content' => 'バッテリーの持ちはどのくらいですか？',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 1,
                'item_id' => 7,
                'content' => '普段使いしやすそうで気になっています。',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 1,
                'item_id' => 10,
                'content' => 'セット内容を詳しく知りたいです。',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}