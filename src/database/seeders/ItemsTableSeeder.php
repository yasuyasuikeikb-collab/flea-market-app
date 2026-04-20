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
            'brand_name' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => 15000,
            'condition' => '良好',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $item1->categories()->attach([1]);

        $item2 = Item::create([
            'id' => 2,
            'user_id' => 1,
            'name' => 'HDD',
            'brand_name' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'price' => 5000,
            'condition' => '目立った傷や汚れなし',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $item2->categories()->attach([2]);

        $item3 = Item::create([
            'id' => 3,
            'user_id' => 1,
            'name' => '玉ねぎ3束',
            'brand_name' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'price' => 300,
            'condition' => 'やや傷や汚れあり',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $item3->categories()->attach([3]);

        $item4 = Item::create([
            'id' => 4,
            'user_id' => 2,
            'name' => '革靴',
            'brand_name' => null,
            'description' => 'クラシックなデザインの革靴',
            'price' => 4000,
            'condition' => '状態が悪い',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $item4->categories()->attach([1]);

        $item5 = Item::create([
            'id' => 5,
            'user_id' => 2,
            'name' => 'ノートPC',
            'brand_name' => null,
            'description' => '高性能なノートパソコン',
            'price' => 45000,
            'condition' => '良好',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $item5->categories()->attach([2]);

        $item6 = Item::create([
            'id' => 6,
            'user_id' => 2,
            'name' => 'マイク',
            'brand_name' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'price' => 8000,
            'condition' => '目立った傷や汚れなし',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $item6->categories()->attach([2]);

        $item7 = Item::create([
            'id' => 7,
            'user_id' => 2,
            'name' => 'ショルダーバッグ',
            'brand_name' => null,
            'description' => 'おしゃれなショルダーバッグ',
            'price' => 3500,
            'condition' => 'やや傷や汚れあり',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $item7->categories()->attach([1]);

        $item8 = Item::create([
            'id' => 8,
            'user_id' => 3,
            'name' => 'タンブラー',
            'brand_name' => 'なし',
            'description' => '使いやすいタンブラー',
            'price' => 500,
            'condition' => '状態が悪い',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $item8->categories()->attach([4]);

        $item9 = Item::create([
            'id' => 9,
            'user_id' => 3,
            'name' => 'コーヒーミル',
            'brand_name' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'price' => 4000,
            'condition' => '良好',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $item9->categories()->attach([4]);

        $item10 = Item::create([
            'id' => 10,
            'user_id' => 3,
            'name' => 'メイクセット',
            'brand_name' => null,
            'description' => '便利なメイクアップセット',
            'price' => 2500,
            'condition' => '目立った傷や汚れなし',
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $item10->categories()->attach([5]);
    }
}