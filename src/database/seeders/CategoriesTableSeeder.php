<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'ファッション', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => '家電', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'name' => 'インテリア', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'name' => 'メンズ', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'name' => 'レディース', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6, 'name' => '本', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 7, 'name' => 'ゲーム', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 8, 'name' => 'スポーツ', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 9, 'name' => 'コスメ', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 10, 'name' => 'おもちゃ', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}