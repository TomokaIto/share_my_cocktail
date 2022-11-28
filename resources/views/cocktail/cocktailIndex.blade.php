@extends('layouts.app')

@section('content')


<h2 class="text-center">Share my Cocktail</h2>
<div class="row justify-content-center w-100">
    <div class="col-8 mt-5">
        @if(auth()->user())
        <div class="d-flex justify-content-between">
            <a class="btn btn-dark" href="#" role="button">投稿一覧</a>
            <a class="btn btn-dark" href="/cocktailCreate" role="button">新規投稿</a>
            <a class="btn btn-dark" href="#" role="button">お気に入り一覧</a>
        </div><br>
        @endif

        <div class="text-center">自分の好きなものを共有して<br>お気に入りのカクテルを探そう</div><br>

        <!-- 検索機能ここから  -->
        <form class="form-inline my-2 my-lg-0 ml-2 justify-content-center">
            <div class="form-group">
                <!-- <input type="search" class="form-control mr-sm-2" name="search" value="{{request('search')}}" placeholder="キーワードを入力" aria-label="検索..."> -->
                <select name="search" class="rounded bg-dark text-light">
                    <option value="">ジャンルを選択</option>
                    <option>ウイスキー</option>
                    <option>ジン</option>
                    <option>ウォッカ</option>
                    <option>ラム</option>
                    <option>ワイン</option>
                    <option>日本酒</option>
                    <option>焼酎</option>
                    <option>果実酒</option>
                    <option>リキュール</option>
                    <option>その他</option>
                </select>
            </div>
            <input type="submit" value="検索" class="btn btn-dark ml-1">
        </form>
        <!-- 検索機能ここまで -->
        <br>
        <div class="card bg-dark">
            <div class="card-body">
                <h5 class="card-title text-center text-light">Cocktail List</h5>

                <div class="container">

                    <div class="row justify-content-center bg-dark">

                        @foreach($posts as $post)
                        <div class="card mb-3 w-100 text-left bg-danger text-white h-25" style="max-width: 540px;">
                            <div class="row g-0">
                                @if($post->image!=null)
                                <div class="col-md-4">
                                    <img src="{{ Storage::url($post->image) }}" class="w-100 h-100">
                                </div>
                                @else
                                <div class="col-md-4">
                                    <img src="{{ asset('storage/images/no_image_square.jpg')}}" class="w-100 h-100">
                                </div>
                                @endif
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="/cocktailShow/{{$post->id}}" class="text-white">{{ $post->cocktail_name }}</a>
                                        </h5>
                                        <p class="card-text"><small class="">Author Name：{{$post->name}}</small></p>
                                        <p class="card-text"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- 検索結果 -->
        <div class="d-flex justify-content-center "> 
            {{ $articles->links() }} 
        </div>
    </div>
</div>
@endsection