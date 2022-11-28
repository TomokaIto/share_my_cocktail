@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity=" sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
<!-- Bootstrap CSS -->
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous"> -->

<div class="container">
    <div class="card mx-auto  bg-dark mt-3 mb-3" style="width: 90%;">
        <div class="card-body bg-dark text-light">
            <h2 class="text-center bg-danger rounded">{{ $post->cocktail_name }}</h2>
            <div class="container">
                <div class="row">
                    <div class="col-2">
                        @if ($mylist && Auth::user()!=null)
                        <form action="{{route('mylists.delete',$mylist)}}" method="POST" class="mb-4">
                            <input type="hidden" name="cocktail_id" value="{{$post->id}}">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                ★お気に入り済み
                            </button>
                        </form>
                        @elseif(Auth::user()!=null)
                        <form action="{{route('mylists.store')}}" method="POST" class="mb-4">
                            @csrf
                            <input type="hidden" name="cocktail_id" value="{{$post->id}}">
                            <button type="submit" class="btn btn-outline-danger">
                                ☆お気に入り登録
                            </button>
                        </form>
                        @endif
                    </div>
                    <div class="col-7"></div>
                    <div class="col-3">
                        お気に入り数:{{$mylistCount}}
                    </div>
                </div>
            </div>
            <p class="card-text">Author Name：{{ $post->name }}</p>
            @if($post->image!=null)
            <img class="d-block mx-auto img-fluid w-25" src="{{ Storage::url($post->image)}}" class="img-thumbnail"><br>
            @else
                <img src="{{ asset('storage/images/no_image_square.jpg')}}" class="d-block mx-auto img-fluid w-25"><br>          
            @endif
            <p class="card-text">ベースのお酒：{{ $post->genre }}</p>
            <div calss="d-inline-flex">
                <p class="card-text d-inline-flex">アルコール度数：{{ $post->degree }}</p>&emsp;&emsp;
                <p class="card-text d-inline-flex">テイスト：{{ $post->taste }}</p>
            </div>
            <p class="card-text">＜材料＞<br>{!! nl2br(e($post->material)) !!}</p>
            <p class="card-text">＜作り方＞<br>{!! nl2br(e($post->make)) !!}</p>
            <p class="card-text">＜おすすめポイント＞<br>{!! nl2br(e($post->recommends)) !!}</p>

        </div>
        @if(auth()->user())
        <div class="text-right mr-5">
            @if(isset($product->like_products[0]))
            <a class="toggle_wish" product_id="{{ $post->id }}" like_product="1">
                <i class="fas fa-heart"></i>
            </a>
            @else
            <a class="toggle_wish" product_id="{{ $post->id }}" like_product="0">
                <i class="far fa-heart"></i>
            </a>
        </div>
        @endif
        <div class="d-flex col">
            <a href="/cocktailEdit/{{$post->id}}" type="button" class="btn btn-outline-light mx-2"><i class="fas fa-file-download mr-1"></i>編集</a>
            <form method="POST" action="/cocktailDelete/{{$post->id}}">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-outline-light" onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt mr-1"></i>削除</button>
            </form>
        </div>
        @endif
        <br><br>
        <a href="/cocktailIndex" class="btn btn-danger btn-sm btn-block mb-3" role="button">BACK</a>
    </div>


</div>
<script>
    function delete_alert(e) {
        if (!window.confirm('本当に削除しますか？')) {
            window.alert('キャンセルされました');
            return false;
        }
        document.deleteform.submit();
    };

    $(function() {
        //「toggle_wish」というクラスを持つタグがクリックされたときに以下の処理が走る
        $('.toggle_wish').on('click', function() {
            console.log('test');
            //表示しているプロダクトのIDと状態、押下し他ボタンの情報を取得
            product_id = $(this).attr("product_id");
            like_product = $(this).attr("like_product");
            click_button = $(this);

            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') //基本的にはデフォルトでOK
                    },
                    url: '/like_product', //route.phpで指定したコントローラーのメソッドURLを指定
                    type: 'POST', //GETかPOSTメソットを選択
                    data: {
                        'product_id': product_id,
                        'like_product': like_product,
                    }, //コントローラーに送るに名称をつけてデータを指定
                })
                //正常にコントローラーの処理が完了した場合
                .done(function(data) //コントローラーからのリターンされた値をdataとして指定
                    {
                        if (data == 0) {
                            //クリックしたタグのステータスを変更
                            click_button.attr("like_product", "1");
                            //クリックしたタグの子の要素を変更(表示されているハートの模様を書き換える)
                            click_button.children().attr("class", "fas fa-heart");
                        }
                        if (data == 1) {
                            //クリックしたタグのステータスを変更
                            click_button.attr("like_product", "0");
                            //クリックしたタグの子の要素を変更(表示されているハートの模様を書き換える)
                            click_button.children().attr("class", "far fa-heart");
                        }
                    })
                ////正常に処理が完了しなかった場合
                .fail(function(data) {
                    alert('いいね処理失敗');
                    alert(JSON.stringify(data));
                });
        });
    });
</script>
@endsection