<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->truncate();
        $now = Carbon::now();

        $categories = \App\Models\Category::pluck('id', 'name'); // name => idのmap
        $conditions = \App\Models\Condition::pluck('id', 'name');

        $products = [
            [
                'name' => '腕時計',
                'price' => 15000,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'product_image' => 'ArmaniMensClock.jpg',
                'category_id' => $categories['メンズ'] ?? 5,
                'condition_id' => $conditions['良好'] ?? 1,
            ],
            [
                'name' => 'HDD',
                'price' => 5000,
                'description' => '高速で信頼性の高いハードディスク',
                'product_image' => 'HDDHardDisk.jpg',
                'category_id' => $categories['家電'] ?? 2,
                'condition_id' => $conditions['目立った傷や汚れなし'] ?? 2,
            ],
            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'description' => '新鮮な玉ねぎ3束のセット',
                'product_image' => '玉ねぎ3束.jpg',
                'category_id' => $categories['キッチン'] ?? 10,
                'condition_id' => $conditions['やや傷や汚れあり'] ?? 3,
            ],
            [
                'name' => '革靴',
                'price' => 4000,
                'description' => 'クラシックなデザインの革靴',
                'product_image' => '革靴.jpg',
                'category_id' => $categories['ファッション'] ?? 1,
                'condition_id' => $conditions['状態が悪い'] ?? 4,
            ],
            [
                'name' => 'ノートPC',
                'price' => 45000,
                'description' => '高性能なノートパソコン',
                'product_image' => 'NptePC.jpg',
                'category_id' => $categories['家電'] ?? 2,
                'condition_id' => $conditions['良好'] ?? 1,
            ],
            [
                'name' => 'マイク',
                'price' => 8000,
                'description' => '高音質のレコーディング用マイク',
                'product_image' => 'MusicMic4632231.jpg',
                'category_id' => $categories['家電'] ?? 2,
                'condition_id' => $conditions['目立った傷や汚れなし'] ?? 2,
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'description' => 'おしゃれなショルダーバッグ',
                'product_image' => 'Pursefashionpocket.jpg',
                'category_id' => $categories['ファッション'] ?? 1,
                'condition_id' => $conditions['やや傷や汚れあり'] ?? 3,
            ],
            [
                'name' => 'タンブラー',
                'price' => 500,
                'description' => '使いやすいタンブラー',
                'product_image' => 'Tumblersouvenir.jpg',
                'category_id' => $categories['キッチン'] ?? 10,
                'condition_id' => $conditions['状態が悪い'] ?? 4,
            ],
            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'description' => '手動のコーヒーミル',
                'product_image' => 'WaitresswithCoffeeGrinder.jpg',
                'category_id' => $categories['キッチン'] ?? 10,
                'condition_id' => $conditions['良好'] ?? 1,
            ],
            [
                'name' => 'メイクセット',
                'price' => 2500,
                'description' => '便利なメイクアップセット',
                'product_image' => '外出メイクアップセット.jpg',
                'category_id' => $categories['コスメ'] ?? 6,
                'condition_id' => $conditions['目立った傷や汚れなし'] ?? 2,
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'user_id' => $userId = \App\Models\User::inRandomOrder()->first()->id,
                'category_id' => $product['category_id'],
                'condition_id' => $product['condition_id'],
                'name' => $product['name'],
                'description' => $product['description'],
                'brand_name' => '',
                'price' => $product['price'],
                'sold_out' => false,
                'product_image' => $product['product_image'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
