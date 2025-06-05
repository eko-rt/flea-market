<?php

namespace App\Http\Controllers;

use App\Modedls\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Condition;

class SellController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('auth.sell', compact('categories', 'conditions'));
    }

    public function store(Request $request)
    {
    
        $product = Product::create([
            // ...商品情報
        ]);

        // カテゴリーを紐付け
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        // リダイレクト等
    }
}
