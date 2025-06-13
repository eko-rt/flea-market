<?php

namespace App\Http\Controllers;

use App\Modedls\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Condition;
use App\Http\Requests\StoreProductRequest;

class SellController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('auth.sell', compact('categories', 'conditions'));
    }

    public function store(StoreProductRequest $request)
    {
    
        $validated = $request->validated();

        // 画像保存
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/products-img');
            $imagePath = basename($imagePath);
        }


        $product = \App\Models\Product::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'brand_name' => $validated['brand_name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'condition_id' => $validated['condition_id'],
            'product_image' => $imagePath,
            // 他のカラムも必要に応じて
        ]);
        // カテゴリーを紐付け
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        // マイページへリダイレクト
        return redirect()->route('mypage')->with('success', '商品を出品しました');
    }
}
