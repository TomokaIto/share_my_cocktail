<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LikeProduct;

class LikeController extends Controller
{
    public function like_product(Request $request)
    {
        
        if ($request->input('like_product') == 0) {
            //ステータスが0のときはデータベースに情報を保存
            // LikeProduct::create([
            //     'product_id' => $request->input('product_id'),
            //     'user_id' => auth()->user()->id,
            // ]);
            $like = new LikeProduct();
            $like->product_id = $request->product_id;
            $like->user_id = \Auth::user()->id;
    
            $like->save();
    
            //ステータスが1のときはデータベースに情報を削除
        } elseif ($request->input('like_product')  == 1) {
            LikeProduct::where('product_id', "=", $request->input('product_id'))
                ->where('user_id', "=", auth()->user()->id)
                ->delete();
        }
        return  $request->input('like_product');
    }
}
