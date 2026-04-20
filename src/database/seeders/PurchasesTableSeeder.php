<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PurchasesTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('purchases')->insert([
            [
                'user_id' => 2,
                'item_id' => 3,
                'payment_method' => 'カード',
                'postal_code' => '530-0001',
                'address' => '大阪府大阪市北区梅田1-2-3',
                'building' => '梅田マンション202',
                'purchased_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 1,
                'item_id' => 8,
                'payment_method' => 'コンビニ',
                'postal_code' => '150-0001',
                'address' => '東京都渋谷区神宮前1-1-1',
                'building' => '原宿ハイツ101',
                'purchased_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}