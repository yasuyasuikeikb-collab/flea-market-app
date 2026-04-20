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
                'item_id' => 1,
                'payment_method' => 'カード',
                'postal_code' => '530-0001',
                'address' => '大阪府大阪市北区梅田1-2-3',
                'building' => '梅田マンション202',
                'purchased_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 3,
                'item_id' => 7,
                'payment_method' => 'コンビニ',
                'postal_code' => '460-0008',
                'address' => '愛知県名古屋市中区栄3-3-3',
                'building' => '栄ビル303',
                'purchased_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}