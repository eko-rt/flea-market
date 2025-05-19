<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function store(Request $request, $item_id)
{
    $request->validate([
        'body' => 'required|string|max:255',
    ], [
        'body.required' => 'コメントを入力してください。',
        'body.max' => 'コメントは255文字以内で入力してください。',
    ]);

    $product = \App\Models\Product::findOrFail($item_id);

    $product->comments()->create([
        'user_id' => auth()->id(),
        'content' => $request->input('body'),
    ]);

    return redirect()->back();
}
}
