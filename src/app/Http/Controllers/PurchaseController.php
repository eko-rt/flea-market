<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PurchaseController extends Controller
{
    //

    public function show($item_id)
    {
        $product = Product::findOrFail($item_id);
        $payment_methods = PaymentMethod::all();
        return view('auth.purchase', compact('product', 'payment_methods'));
    }

    public function store(Request $request, $item_id)
{
    // 購入処理をここに記述
    // 例: 購入レコードの作成や在庫更新など

    // 完了後にリダイレクト
    return redirect()->route('products.index')->with('success', '購入が完了しました');
}
}
