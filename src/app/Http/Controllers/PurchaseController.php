<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    //

    public function show($item_id)
    {
        $product = Product::findOrFail($item_id);
        if ($product->sold_out) {
            return redirect()
                ->route('products.index')
                ->with('error', 'この商品は売り切れです');
        }
    
        $payment_methods = PaymentMethod::all();
        return view('auth.purchase', compact('product', 'payment_methods'));
    }

    public function store(Request $request, $item_id)
    {
        $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $user    = Auth::user();
        $product = Product::findOrFail($item_id);


        if ($product->sold_out) {
            return redirect()
                ->route('products.index')
                ->with('error', 'この商品は売り切れです');
        }

        Purchase::create([
            'user_id'           => $user->id,
            'product_id'        => $product->id,
            'address'           => $user->post_code . ' ' . $user->address . ($user->building_name ? ' ' . $user->building_name : ''),
            'payment_method_id' => $request->payment_method_id,
        ]);

        $product->sold_out = true;
        $product->save();

        return redirect()
               ->route('mypage', ['tab' => 'purchased'])
               ->with('success', '購入が完了しました');
    }
}
