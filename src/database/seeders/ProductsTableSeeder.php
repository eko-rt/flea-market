<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\User;
class ProductsTableSeeder extends Seeder
{

    public function run(): void
    {

        DB::table('products')->delete();

        $now = Carbon::now();

        $categories = \App\Models\Category::pluck('id', 'name');
        $conditions = \App\Models\Condition::pluck('id', 'name');

        $products = [
            [
                'name' => '腕時計',
                'price' => 15000,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'product_image' => 'ArmaniMensClock.jpg',
                'category_ids' => [$categories['メンズ'] ?? 5],
                'condition_id' => $conditions['良好'] ?? 1,
            ],
            [
                'name' => 'HDD',
                'price' => 5000,
                'description' => '高速で信頼性の高いハードディスク',
                'product_image' => 'HDDHardDisk.jpg',
                'category_ids' => [$categories['家電'] ?? 2],
                'condition_id' => $conditions['目立った傷や汚れなし'] ?? 2,
            ],
            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'description' => '新鮮な玉ねぎ3束のセット',
                'product_image' => '玉ねぎ3束.jpg',
                'category_ids' => [$categories['キッチン'] ?? 10],
                'condition_id' => $conditions['やや傷や汚れあり'] ?? 3,
            ],
            [
                'name' => '革靴',
                'price' => 4000,
                'description' => 'クラシックなデザインの革靴',
                'product_image' => '革靴.jpg',
                'category_ids' => [$categories['ファッション'] ?? 1],
                'condition_id' => $conditions['状態が悪い'] ?? 4,
            ],
            [
                'name' => 'ノートPC',
                'price' => 45000,
                'description' => '高性能なノートパソコン',
                'product_image' => 'NptePC.jpg',
                'category_ids' => [$categories['家電'] ?? 2],
                'condition_id' => $conditions['良好'] ?? 1,
            ],
            [
                'name' => 'マイク',
                'price' => 8000,
                'description' => '高音質のレコーディング用マイク',
                'product_image' => 'MusicMic4632231.jpg',
                'category_ids' => [$categories['家電'] ?? 2],
                'condition_id' => $conditions['目立った傷や汚れなし'] ?? 2,
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'description' => 'おしゃれなショルダーバッグ',
                'product_image' => 'Pursefashionpocket.jpg',
                'category_ids' => [$categories['ファッション'] ?? 1],
                'condition_id' => $conditions['やや傷や汚れあり'] ?? 3,
            ],
            [
                'name' => 'タンブラー',
                'price' => 500,
                'description' => '使いやすいタンブラー',
                'product_image' => 'Tumblersouvenir.jpg',
                'category_ids' => [$categories['キッチン'] ?? 10],
                'condition_id' => $conditions['状態が悪い'] ?? 4,
            ],
            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'description' => '手動のコーヒーミル',
                'product_image' => 'WaitresswithCoffeeGrinder.jpg',
                'category_ids' => [$categories['キッチン'] ?? 10],
                'condition_id' => $conditions['良好'] ?? 1,
            ],
            [
                'name' => 'メイクセット',
                'price' => 2500,
                'description' => '便利なメイクアップセット',
                'product_image' => '外出メイクアップセット.jpg',
                'category_ids' => [$categories['コスメ'] ?? 6],
                'condition_id' => $conditions['目立った傷や汚れなし'] ?? 2,
            ],
        ];

        foreach ($products as $item) {
            $product = Product::create([
                'user_id' => User::inRandomOrder()->first()->id,
                'condition_id' => $item['condition_id'],
                'name' => $item['name'],
                'description' => $item['description'],
                'brand_name' => '',
                'price' => $item['price'],
                'sold_out' => false,
                'product_image' => $item['product_image'],
            ]);
            $product->categories()->sync($item['category_ids']);

        }

    }
}