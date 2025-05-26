<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function updateAddress(Request $request, $item_id)
    {
        $request->validate([
            'post_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building_name' => 'nullable|string|max:255',
        ]);
        $user = auth()->user();
        $user->post_code = $request->post_code;
        $user->address = $request->address;
        $user->building_name = $request->building_name;
        $user->save();

        // 商品購入画面にリダイレクト
        return redirect()->route('purchase.show', $item_id)->with('success', '住所を更新しました');
    }


    public function mypage(Request $request)
    {
        $tab = $request->query('tab', 'listing');
        $user = auth()->user();

        $listedProducts    = $user->products;             // 出品した商品
        $purchasedProducts = $user->purchases->map->product; // 購入履歴から商品を取得

        return view('auth.mypage', compact('tab', 'listedProducts', 'purchasedProducts'));
    }
}


