<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\PaymentMethod;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');
        $keyword = $request->input('keyword');
    
        if ($tab === 'mylist' && auth()->check()) {
            $user = auth()->user();
            $products = $user->likes()->with('product')->get()->pluck('product');
        } else {
            $products = Product::query()
                ->when($keyword, fn($q) => $q->where('name', 'like', "%{$keyword}%"))
                ->when(auth()->check(), fn($q) => $q->where('user_id', '!=', auth()->id()))
                ->get();
        }
    
        return view('auth.index', compact('products', 'tab', 'keyword'));
    }

    public function like($item_id)
    {
        $product = Product::findOrFail($item_id);
        $user = auth()->user();
        // すでにいいねしていなければ登録
        if (!$product->likes()->where('user_id', $user->id)->exists()) {
        $product->likes()->create(['user_id' => $user->id]);
        }
        return back();
    }

    public function unlike($item_id)
    {
        $product = Product::findOrFail($item_id);
        $user = auth()->user();
        // いいねを解除
        $product->likes()->where('user_id', $user->id)->delete();
        return back();
    }
    
    

    public function show($item_id)
    {
        $product = Product::findOrFail($item_id);

        return view('auth.product_detail', compact('product' ));
    }
}


