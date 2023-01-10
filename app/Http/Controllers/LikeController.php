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

            if(\Auth::check()){
                $like->user_id = \Auth::user()->id;
            }else{
                $like->ip = $request->ip();
            }
    
            $like->save();
    
            //ステータスが1のときはデータベースに情報を削除
        } elseif ($request->input('like_product')  == 1) {
            $like = LikeProduct::where('product_id', "=", $request->input('product_id'));
                
                if(\Auth::check()){
                    $like = $like->where('user_id', '=', \Auth::user()->id);
                }else{
                    $like = $like->where('ip', "=", $request->ip());
                }
                $like->delete();
        }
        return  $request->input('like_product');
    }
}
