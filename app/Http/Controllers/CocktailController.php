<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cocktail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\MyList;
use App\Models\User;
use App\Models\Review;


class CocktailController extends Controller
{
    public function cocktailIndex()
    {
        $posts = DB::table('cocktails')
            ->join('users', 'cocktails.user_id', '=', 'users.id')
            ->select('cocktails.*', 'users.name')
            ->orderBy('updated_at', 'desc')
            ->get();
        // ->simplePaginate($perPage = 6, $columns = ['*'], $pageName = 'posts');
        $articles = Cocktail::orderBy('created_at', 'asc')->where(function ($query) {

            // 検索機能
            if ($search = request('search')) {
                $query->where('genre', "%{$search}%");
            }
        })->paginate(8);
        return view('cocktail.cocktailIndex', compact('posts', 'articles'));
    }
    public function cocktailSearch(Request $request)
    {
        $posts = DB::table('cocktails')
            ->join('users', 'cocktails.user_id', '=', 'users.id')
            ->select('cocktails.*', 'users.name')
            ->where('genre', $request->input('search_param'))
            ->orderBy('updated_at', 'desc')
            ->get();
        return response()->json($posts);
    }

    public function cocktailCreate()
    {
        return view('cocktail.cocktailCreate');
    }

    public function cocktailPost(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'cocktail_name' => ['required'],
            'genre' => ['required'],
            'degree' => ['required'],
            'taste' => ['required'],
            'material' => ['required'],
            'make' => ['required'],
            // 'recommends' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect('/cocktailCreate')
                ->withErrors($validator)
                ->withInput();
        }
        $cocktail = new Cocktail;

        $cocktail->cocktail_name = $request->cocktail_name;
        $cocktail->genre = $request->genre;
        $cocktail->degree = $request->degree;
        $cocktail->taste = $request->taste;
        $cocktail->material = $request->material;
        $cocktail->make = $request->make;
        $cocktail->recommends = $request->recommends;
        $cocktail->user_id = \Auth::user()->id;
        $cocktail->image = $request->file('image');

        if ($cocktail->image) {
            $filename = request()->file('image')->getClientOriginalName();
            $cocktail['image'] = request('image')->storeAs('public/images', $filename);
        }

        $cocktail->save();




        return redirect('/cocktailIndex')->with('flash_message', '投稿が完了しました');
    }

    public function cocktailShow(Request $request, $id)
    {
        // $post = Cocktail::find($id); //メインキーを検索
        $post = DB::table('cocktails')
            ->join('users', 'cocktails.user_id', '=', 'users.id')
            ->select('cocktails.*', 'users.name')
            ->where('cocktails.id', $id)
            ->first();

        $mylist = '';
        if (\Auth::user() != null) {
            $mylists = MyList::where('cocktail_id', $id)->where('user_id', \Auth::user()->id)->get();
            // // dd(count($mylists));
            if (count($mylists) <= 1) {
                $mylist = false;
            } else {
                $mylist = $mylists[0]->id;
            }
        }

        $mylistCount = DB::table('my_lists')
            ->select('my_lists.id')
            ->where('my_lists.cocktail_id', '=', $id)
            ->count();

        $like = DB::table('like_products')
            ->where('product_id', '=', $id);

        if (\Auth::check()) {
            $like = $like->where('like_products.user_id', '=', \Auth::user()->id);
        } else {
            $like = $like->where('like_products.ip', '=', $request->ip());
        }
        $like = $like->count();

        if ($like !== 0) {
            $like = '1';
        } else {
            $like = '0';
        }

        $reviewList = DB::table('reviews')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->select('reviews.*','users.name')
            ->where('reviews.cocktail_id', '=', $id)
            ->get();

        return view('cocktail.cocktailShow', compact('post', 'mylist', 'mylistCount', 'like', 'reviewList'));
    }

    public function cocktailEdit($id)
    {
        $date = Cocktail::find($id);
        if (is_null($date)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect('/');
        }
        return view('cocktail.cocktailEdit', compact('date'));
    }

    public function cocktailUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cocktail_name' => ['required'],
            'genre' => ['required'],
            'degree' => ['required'],
            'taste' => ['required'],
            'material' => ['required'],
            'make' => ['required'],
            // 'recommends' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect("/cocktailEdit/{{$request->id}}")
                ->withErrors($validator)
                ->withInput();
        }

        $cocktail = Cocktail::find($request->id);

        $cocktail->cocktail_name = $request->cocktail_name;
        $cocktail->genre = $request->genre;
        $cocktail->degree = $request->degree;
        $cocktail->taste = $request->taste;
        $cocktail->material = $request->material;
        $cocktail->make = $request->make;
        $cocktail->recommends = $request->recommends;
        $cocktail->user_id = \Auth::user()->id;
        $cocktail->image = $request->file('image');

        if ($cocktail->image) {
            $filename = request()->file('image')->getClientOriginalName();
            $cocktail['image'] = request('image')->storeAs('public/images', $filename);
        }
        $cocktail->user_id = \Auth::user()->id;

        $cocktail->save();
        return redirect('/cocktailIndex')->with('flash_message', '更新が完了しました');
    }

    public function cocktailDelete($id)
    {
        Cocktail::where('id', $id)->delete();
        return redirect('/cocktailIndex')->with('flash_message', '削除しました');
    }

    public function cocktailMylist()
    {
        $posts = DB::table('cocktails')
            ->join('users', 'cocktails.user_id', '=', 'users.id')
            ->select('cocktails.*', 'users.name')
            ->where('cocktails.user_id', \Auth::user()->id)
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('cocktail.cocktailMylist', compact('posts'));
    }

    public function cocktailMyfavorite()
    {
        $posts = DB::table('cocktails')
            ->join('users', 'cocktails.user_id', '=', 'users.id')
            ->join('my_lists', 'my_lists.cocktail_id', '=', 'cocktails.id')
            ->select('cocktails.*', 'users.name')
            ->where('my_lists.user_id', \Auth::user()->id)
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('cocktail.cocktailMyfavorite', compact('posts'));
    }

    public function userIndex()
    {
        $users = User::all();

        return view('admin.userIndex', compact('users'));
    }

    public function userDelete($id)
    {
        User::where('id', $id)->delete();
        return redirect('/userIndex')->with('flash_message', '削除しました');
    }

    public function review(Request $request){
        
        $review = new Review;
        $review->cocktail_id = $request->cocktail_id;
        $review->user_id = \Auth::user()->id;
        $review->review = $request->review;
        $review->comment = $request->comment;

        $review->save();
              
        // return redirect()->route('posts.show',[$request->post_id]);
        // return view('cocktail.cocktailShow', compact('mylist', 'post', 'mylistCount' ,'like','reviewList'))->with('flash_message', '投稿が完了しました');
        return redirect("/cocktailShow/$request->cocktail_id")->with('flash_message', 'レビューの投稿が完了しました');
    }

    public function reviewDelete(Request $request, $id)
    {
        Review::where('id', $id)->delete();
        return redirect("/cocktailShow/$request->cocktail_id")->with('flash_message', 'レビューを削除しました');
    }

}
