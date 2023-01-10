<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyList;
use App\Models\User;
use App\Models\Cocktail;
use Illuminate\Support\Facades\DB;

class MylistController extends Controller
{
    public function store(Request $request)
    {   
        $mylist = new MyList;
        $mylist->cocktail_id = $request->cocktail_id;
        $mylist->user_id = \Auth::user()->id;

        $mylist->save();

        // $post = Cocktail::find($request->cocktail_id); //メインキーを検索

        // $mylistCount = DB::table('my_lists')

        //     ->select('my_lists.id')
        //     ->where('my_lists.cocktail_id', '=', $request->cocktail_id)
        //     ->count();

        //     $like = DB::table('like_products')
        //     ->where('product_id', '=', $request->cocktail_id);

        // if (\Auth::check()) {
        //     $like = $like->where('like_products.user_id', '=', \Auth::user()->id);
        // } else {
        //     $like = $like->where('like_products.ip', '=', $request->ip());
        // }
        // $like = $like->count();

        // if ($like !== 0) {
        //     $like = '1';
        // } else {
        //     $like = '0';
        // }

        // $reviewList = DB::table('reviews')
        //     ->join('users', 'reviews.user_id', '=', 'users.id')
        //     ->select('cocktails.*', 'users.name')
        //     ->where('reviews.cocktail_id', '=', $request->cocktail_id)
        //     ->get();
        // return redirect()->route('posts.show',[$request->post_id]);
        // return view('cocktail.cocktailShow', compact('mylist', 'post', 'mylistCount' ,'like','reviewList'));
        return redirect("/cocktailShow/$request->cocktail_id");
    }


    public function delete(Request $request, $id)
    {
        $mylist = MyList::findOrFail($id);

        $mylist->delete();

        // return redirect()->route('posts.show',[$request->post_id]);

        // return view('posts/show', compact('mylist','post','comments'));
        return redirect("/cocktailShow/$request->cocktail_id");
    }


}
