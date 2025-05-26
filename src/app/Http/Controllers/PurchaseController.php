<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    //

    public function show($item_id)
    {
        $product = Product::findOrFail($item_id);
        return view('auth.purchase', compact('product'));
    }

    public function store(Request $request, $item_id)
{
    // 購入処理をここに記述
    // 例: 購入レコードの作成や在庫更新など

    // 完了後にリダイレクト
    return redirect()->route('products.index')->with('success', '購入が完了しました');
}
}
