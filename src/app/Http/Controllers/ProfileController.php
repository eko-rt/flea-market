<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

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
        // 出品した商品
        $listedProducts    = $user->products;
        
        // 購入した商品（purchasesリレーション経由でproductを取得）
        $purchasedProducts = $user->purchases()->with('product')->get()->pluck('product')->filter();

        return view('auth.mypage', compact('tab', 'listedProducts', 'purchasedProducts'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'post_code' => 'required|string|max:10',
            'address' => 'nullable|string|max:255',
            'building_name' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->post_code = $request->post_code;
        $user->address = $request->address;
        $user->building_name = $request->building_name;

        // 画像アップロード処理
        if ($request->hasFile('profile_image')) {
            $filename = uniqid() . '.' . $request->profile_image->extension();
            $request->profile_image->storeAs('public/profile-img', $filename);
            $user->profile_image = $filename;
        }

        $user->save();

        // マイページ（mypage.blade.php）へリダイレクト
        return redirect()->route('mypage')->with('success', 'プロフィールを更新しました');
    }

}


