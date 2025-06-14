<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    //
    public function store(CommentRequest $request, $item_id)
    {
        $request->validated();
        $product = \App\Models\Product::findOrFail($item_id);

        $product->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->input('body'),
        ]);

        return redirect()->back();
    }
}
