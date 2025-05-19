<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\productg;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
    
        $products = Product::query()
            // キーワード検索（商品名の部分一致）
            ->when($keyword, function ($query, $keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            // ログイン中なら自分の商品を除外
            ->when(Auth::check(), function ($query) {
                $query->where('user_id', '!=', Auth::id());
            })
            ->get();
    
        return view('index', compact('products', 'keyword'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Product::query();

        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        $products = $query->get();

        return view('auth.index', compact('products', 'keyword'));
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
    

    
    //修正する
    public function mylist()
    {
        if (!auth()->check()) {
            return view('auth.index', ['products' => collect(), 'tab' => 'mylist']);
        }

        $user = auth()->user();
        // いいねした商品のみ取得（likesテーブルのリレーションがある場合）
        $products = $user->likes()->with('product')->get()->pluck('product');

        return view('auth.index', [
        'products' => $products,
        'tab' => 'mylist'
        ]);
    }


    public function show($item_id)
    {
        $product = Product::findOrFail($item_id);
        return view('auth.product_detail', compact('product'));
    }
}


