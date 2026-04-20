<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ItemsTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $item1 = Item::create([
            'id' => 1,
            'user_id' => 1,
            'name' => '腕時計',
            'brand_name' => 'SEIKO',
            'description' => 'シンプルで使いやすい腕時計です。',
            'price' => 15000,
            'condition' => '良好',
            'image_path' => 'items/watch.png',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $item1->categories()->attach([1, 4]);

        $item2 = Item::create([
            'id' => 2,
            'user_id' => 2,
            'name' => 'ワイヤレスイヤホン',
            'brand_name' => 'SONY',
            'description' => 'ノイズキャンセリング機能付きのワイヤレスイヤホンです。',
            'price' => 22000,
            'condition' => '目立った傷や汚れなし',
            'image_path' => 'items/earphones.png',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $item2->categories()->attach([2]);

        $item3 = Item::create([
            'id' => 3,
            'user_id' => 1,
            'name' => '木製チェア',
            'brand_name' => null,
            'description' => 'ナチュラルテイストの木製チェアです。',
            'price' => 8000,
            'condition' => 'やや傷や汚れあり',
            'image_path' => 'items/chair.png',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $item3->categories()->attach([3]);

        $item4 = Item::create([
            'id' => 4,
            'user_id' => 3,
            'name' => 'ランニングシューズ',
            'brand_name' => 'NIKE',
            'description' => '軽量で走りやすいランニングシューズです。',
            'price' => 9800,
            'condition' => '新品・未使用',
            'image_path' => 'items/shoes.png',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $item4->categories()->attach([1, 8]);

        $item5 = Item::create([
            'id' => 5,
            'user_id' => 2,
            'name' => '文庫小説セット',
            'brand_name' => null,
            'description' => '人気作家の文庫本5冊セットです。',
            'price' => 2500,
            'condition' => 'やや傷や汚れあり',
            'image_path' => 'items/books.png',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $item5->categories()->attach([6]);

        $item6 = Item::create([
            'id' => 6,
            'user_id' => 3,
            'name' => '家庭用ゲーム機',
            'brand_name' => 'Nintendo',
            'description' => 'コントローラー付きの家庭用ゲーム機です。',
            'price' => 30000,
            'condition' => '良好',
            'image_path' => 'items/game.png',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $item6->categories()->attach([7]);

        $item7 = Item::create([
            'id' => 7,
            'user_id' => 1,
            'name' => 'スキンケアセット',
            'brand_name' => 'SHISEIDO',
            'description' => '化粧水・乳液・美容液の3点セットです。',
            'price' => 6800,
            'condition' => '新品・未使用',
            'image_path' => 'items/cosmetics.png',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $item7->categories()->attach([9]);

        $item8 = Item::create([
            'id' => 8,
            'user_id' => 2,
            'name' => 'ぬいぐるみ',
            'brand_name' => null,
            'description' => '大きめサイズのかわいいぬいぐるみです。',
            'price' => 3200,
            'condition' => '未使用に近い',
            'image_path' => 'items/toy.png',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $item8->categories()->attach([10]);
    }
}