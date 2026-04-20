<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => '山田 太郎',
                'email' => 'taro@example.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password123'),
                'profile_image' => 'profiles/user1.png',
                'postal_code' => '150-0001',
                'address' => '東京都渋谷区神宮前1-1-1',
                'building' => '原宿ハイツ101',
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => '佐藤 花子',
                'email' => 'hanako@example.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password123'),
                'profile_image' => 'profiles/user2.png',
                'postal_code' => '530-0001',
                'address' => '大阪府大阪市北区梅田1-2-3',
                'building' => '梅田マンション202',
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => '鈴木 一郎',
                'email' => 'ichiro@example.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password123'),
                'profile_image' => 'profiles/user3.png',
                'postal_code' => '460-0008',
                'address' => '愛知県名古屋市中区栄3-3-3',
                'building' => '栄ビル303',
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}