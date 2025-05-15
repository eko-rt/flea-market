<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('auth.index', compact('products'));
        $tab = $request->query('page', 'recommend');
        //修正する
    if ($tab === 'mylist' && auth()->check()) {
        $user = auth()->user();
        $products = $user->likes()->with('product')->get()->pluck('product');
    } else {
        $products = \App\Models\Product::all();
    }

    return view('auth.index', [
        'products' => $products,
        'tab' => $tab,
    ]);
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
}


