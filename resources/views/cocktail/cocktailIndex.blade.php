@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> -->
<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity=" sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>

<div class="d-flex w-100 justify-content-center">
    <small class="text-center m-1">お酒の投稿共有サイト</small>
</div>
<h1 class="text-center">Share my Cocktail</h1>

<!-- 投稿、編集、削除完了メッセージ -->
@if (session('flash_message'))
<br>
<div class="d-flex align-items-center justify-content-center">
    <div class="flash_message bg-danger text-center py-3 my-0 w-25 rounded">
        {{ session('flash_message') }}
    </div>
</div>
@endif

<div class="row justify-content-center w-100">
    <div class="col-8 mt-5">
        <!-- @if(auth()->user())
        <div class="d-flex justify-content-between">
            <a class="btn btn-dark" href="/cocktailMylist" role="button">投稿一覧</a>
            <a class="btn btn-dark" href="/cocktailCreate" role="button">新規投稿</a>
            <a class="btn btn-dark" href="/cocktailMyfavorite" role="button">お気に入り一覧</a>
            @if(Auth::user()->role === 0)
            <a class="btn btn-dark" href="/userIndex" role="button">ユーザ一覧</a>
            @endif
        </div><br>
        @endif -->
        <div class="d-flex w-100 justify-content-center">
            <div class="d-flex align-items-center justify-content-center">
                <div class="text-center  m-3 text-dark rounded p-2 " style="background-color: rgba(255, 255, 255, 0.8); font-size: 18px;">
                    自分の好きなものを共有して<br>お気に入りのカクテルを探そう
                </div><br>
            </div>
            <!-- 検索機能ここから  -->
            <div class="form-inline my-2 my-lg-0 ml-2 justify-content-center m-3">
                <div class="form-group">

                    <select name="search" class="rounded text-black border-black form-control form-control-lg" style="background-color: rgba(192, 192, 192, 0.9); font-size: 18px; color:black;" id="search_name">
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
                <input type="button" value="検索" class="btn btn-secondary ml-2" style="color:black; background-color: rgba(192, 192, 192, 0.9); font-size: 20px;" onclick="searchButton()">
            </div>
            <!-- 検索機能ここまで -->
        </div>
        <br>
        <div>
            <div class="card bg-transparent border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center">
                        <h4 class="card-title text-center text-light w-25 mb-3 p-2 rounded" style="background-color: rgba(128, 128, 128, 0.8);">Cocktail List</h4>
                    </div><br>
                    <div id="post-table">

                        <div class="container">

                            <div class="row justify-content-center">

                                @foreach($posts as $post)
                                <div class="card mb-3 w-100 text-left  h-25 border-0" style="max-width: 540px; background-color: rgba(192, 192, 192, 1); color:black;">
                                    <div class="row g-0">
                                        @if($post->image!=null)
                                        <div class="col-md-4">
                                            <img src="{{ Storage::url($post->image) }}" class="w-100" style="height: 150px;">
                                        </div>
                                        @else
                                        <div class="col-md-4">
                                            <img src="{{ asset('storage/images/no_image_square.jpg')}}" class="w-100" style="height: 150px; opacity: 0.5;">
                                        </div>
                                        @endif
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <a href="/cocktailShow/{{$post->id}}" class="" style="color:black;">{{ $post->cocktail_name }}</a>
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
            </div>
        </div>

    </div>
</div>




@endsection
<script>
    function searchButton() {
        let param = $('#search_name').val(); // 検索ワードを取得

        if (param == '') {
            alert('ジャンルを選択してください')
            return false;
        } //ガード節で検索ワードが空の時、ここで処理を止めて何もビューに出さない


        // $.ajax({
        //     type: 'GET',
        //     url: '/cocktailSearch', //後述するweb.phpのURLと同じ形にする
        //     data: {
        //         'search_param': param, //ここはサーバーに贈りたい情報。今回は検索ファームのバリューを送りたい。
        //     },
        //     dataType: 'json', //json形式で受け取る

        //     beforeSend: function() {
        //         // $('.loading').removeClass('display-none');
        //     } //通信中の処理をここで記載。今回はぐるぐるさせるためにcssでスタイルを消す。
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') //基本的にはデフォルトでOK
            },
            url: '/cocktailSearch', //route.phpで指定したコントローラーのメソッドURLを指定
            type: 'GET', //GETかPOSTメソットを選択
            data: {
                'search_param': param,
            }, //コントローラーに送るに名称をつけてデータを指定

        }).done(function(data) {
            console.log(data);
            // 検索結果がなかったときの処理
            if (data.length === 0) {
                alert('検索結果がありません');
            } else {
                $('#post-table div').empty(); // もともとある要素を空にする
                // // $('.loading').addClass('display-none'); //通信中のぐるぐるを消す
                let html = '';
                $.each(data, function(index, value) { //dataの中身からvalueを取り出す
                    //ここの記述はリファクタ可能
                    let id = value.id;
                    let cocktail_name = value.cocktail_name;
                    let name = value.name;

                    if (value.image == null) {
                        var image = 'storage/images/no_image_square.jpg';
                    } else {
                        var image = value.image;
                        image = image.replace('public/', '/storage/');
                    }
                    // １ユーザー情報のビューテンプレートを作成
                    console.log(image);
                    html = html + `
                    <div class="container">
                        <div class="row justify-content-center bg-transparent">
                            <div class="card mb-3 w-100 text-left h-25 border-0" style="max-width: 540px; background-color: rgba(192, 192, 192, 1); color:black;"">
                                <div class="row g-0">                                   
                                    <div class="col-md-4">
                                        <img src="${image}" class="w-100" style="height: 150px; opacity: 0.5;">
                                    </div>                                    
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <a href="/cocktailShow/${id}" class="" style="color:black;">${cocktail_name }</a>
                                            </h5>
                                            <p class="card-text"><small class="">Author Name：${name}</small></p>
                                            <p class="card-text"></p>
                                        </div>
                                    </div>                                   
                                </div>
                            </div>
                        </div>  
                                            
                    `;
                })
                console.log(html);
                html = html + `<br><div class="d-flex align-items-center justify-content-center">
                <a href="/cocktailIndex" class="btn btn-danger btn-sm btn-block mb-3 w-25" role="button">BACK</a>
                </div>`
                $('#post-table div').append(html); // できあがったテンプレートをビューに追加
            }

        }).fail(function() {
            //ajax通信がエラーのときの処理
            alert('通信エラー');
        })
    }
</script>