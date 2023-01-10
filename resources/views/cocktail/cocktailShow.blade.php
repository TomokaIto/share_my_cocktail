@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity=" sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>

<!-- bootstrap.js -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

<div class="container">

    <div class="card mx-auto  bg-dark mt-3 mb-3" style="width: 90%;">
        <!-- タブ -->
        <ul class="nav">
            <li class="nav-item">
                <button class="nav-link active  text-danger rounded-top border-0 mr-1" data-toggle="tab" onclick="showMain()">Main</button>
            </li>
            <li class="nav-item">
                <button class="nav-link  text-danger rounded-top border-0" data-toggle="tab" onclick="showReview()">Review</button>
            </li>
        </ul>

        <!-- レビュー投稿完了メッセージ -->
        @if (session('flash_message'))
        <br>
        <div class="d-flex align-items-center justify-content-center">
            <div class="flash_message bg-danger text-center py-3 my-0 w-25 rounded">
                {{ session('flash_message') }}
            </div>
        </div>
        @endif

        <div class="card-body bg-dark text-light">
            <h2 class="text-center bg-danger rounded mb-3 ">{{ $post->cocktail_name }}</h2>
            <!-- 詳細画面 -->
            <div id="showMain">
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
                <p class="card-text"><i class="bg-danger p-1 rounded">ベースのお酒</i>&emsp;{{ $post->genre }}</p>
                <hr>
                <div calss="d-flex">
                    <p class="card-text d-inline-flex"><i class="bg-danger p-1 rounded">アルコール度数</i>&emsp;{{ $post->degree }}</p>&emsp;&emsp;
                    <p class="card-text d-inline-flex"><i class="bg-danger p-1 rounded">テイスト</i>&emsp;{{ $post->taste }}</p>
                </div>
                <hr>
                <p class="card-text"><i class="bg-danger p-1 rounded pl-3 pr-3">材料</i>
                <div></div>{!! nl2br(e($post->material)) !!}</p>
                <hr>
                <p class="card-text"><i class="bg-danger p-1 rounded pl-3 pr-3">作り方</i>
                <div></div>{!! nl2br(e($post->make)) !!}</p>
                <hr>
                <p class="card-text"><i class="bg-danger p-1 rounded pl-3 pr-3">おすすめポイント</i>
                <div></div>{!! nl2br(e($post->recommends)) !!}</p>
                <hr>


                <div class="text-right mr-5">
                    <!-- いいね機能 -->
                    @if(isset($product->like_products[0]) || $like == '1')
                    <a class="toggle_wish" product_id="{{ $post->id }}" like_product="1">
                        <i class="fas fa-heart"></i>
                    </a>
                    @else
                    <a class="toggle_wish" product_id="{{ $post->id }}" like_product="0">
                        <i class="far fa-heart"></i>
                    </a>
                </div>
                @endif

                @if (Auth::user()!=null)
                @if ($post->user_id === Auth::user()->id || Auth::user()->role === 0)
                <div class="d-flex col">
                    <a href="/cocktailEdit/{{$post->id}}" type="button" class="btn btn-outline-light mx-2"><i class="fas fa-file-download mr-1"></i>編集</a>
                    <form method="POST" action="/cocktailDelete/{{$post->id}}">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-outline-light" onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt mr-1"></i>削除</button>
                    </form>
                </div>
                @endif
                @endif
            </div>
        </div>
        <!-- レビュー画面 -->
        <div class="d-none mr-4 ml-4" id="showReview">
            @if(auth()->user())
            @if ($post->user_id != Auth::user()->id)
            <h3 class="text-center mb-3">レビュー</h3>
            <form action="{{route('review')}}" method="post">
                @csrf
                <div class="mb-3">
                    <!-- <label for="exampleFormSelect1" class="form-label">選択の例</label> -->
                    <select class="form-select mb-3" id="exampleFormSelect1" name="review" required>
                        <option value="">評価</option>
                        <option value="1">★</option>
                        <option value="2">★★</option>
                        <option value="3">★★★</option>
                        <option value="4">★★★★</option>
                        <option value="5">★★★★★</option>
                    </select><br>
                    <!-- <input type="text" class="form-control" id="Input" placeholder="コメント" name="comment"> -->
                    <label>コメント</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" wrap="off" name="comment" style="resize:none;"></textarea>
                </div>
                <input type="hidden" name="cocktail_id" value="{{$post->id}}">
                <button type="submit" class="btn btn-light text-danger font-weight-bold">送信</button>
            </form>
            <hr>
            @endif
            @endif
            <h3 class="text-center mb-3 mt-3">レビュー一覧</h3>
            @foreach($reviewList as $review)
            <div calss="d-inline-flex">
                <p class="card-text d-inline-flex mr-5 mb-0"><i class="bg-danger p-1 rounded">Name</i>&emsp;{{ $review->name }}</p>
                @if($review->review == '1')
                <p class="card-text d-inline-flex"><i class="bg-danger p-1 rounded">評価</i>&emsp;★</p>
                @elseif($review->review == '2')
                <p class="card-text d-inline-flex"><i class="bg-danger p-1 rounded">評価</i>&emsp;★★</p>
                @elseif($review->review == '3')
                <p class="card-text d-inline-flex"><i class="bg-danger p-1 rounded">評価</i>&emsp;★★★</p>
                @elseif($review->review == '4')
                <p class="card-text d-inline-flex"><i class="bg-danger p-1 rounded">評価</i>&emsp;★★★★</p>
                @elseif($review->review == '5')
                <p class="card-text d-inline-flex"><i class="bg-danger p-1 rounded">評価</i>&emsp;★★★★★</p>
                @endif
                @if(auth()->user())
                @if ($review->user_id === Auth::user()->id || Auth::user()->role === 0)
                <div class=" d-inline-flex ml-5 text-right">
                <form method="POST" action="/reviewDelete/{{$review->id}}">
                    {{ csrf_field() }}
                    <input type="hidden" name="cocktail_id" value="{{$post->id}}">
                    <button type="submit" class="btn btn-outline-light" onClick="delete_alert(event);return false;"><i class="fas fa-trash-alt mr-1"></i>削除</button>
                </form>
                </div>
                @endif
                @endif
            </div>           
            @if($review->comment !== null)
            <br>
            <p class="card-text"><i class="bg-danger p-1 rounded">コメント</i><br>{!! nl2br(e($review->comment)) !!}</p>
            @endif
            <hr style="border-width: 4px;">
            @endforeach
        </div>

        <br>
        <div class="d-flex justify-content-center">
            <a href="#" class="btn btn-danger btn-sm btn-block mb-5 mt-2 w-25" role="button" onclick="history.back(-1);return false;">BACK</a>
        </div>
    </div>

</div>


</div>
<script>
    // $(document).ready(function() {
    //     // ページ読み込み時に実行したい処理
    //     const data = '{{$like}}';
    //     console.log(data);
    //     if (data == 0) {
    //         //クリックしたタグのステータスを変更
    //         click_button.attr("like_product", "1");
    //         //クリックしたタグの子の要素を変更(表示されているハートの模様を書き換える)
    //         click_button.children().attr("class", "fas fa-heart");
    //     }
    //     if (data == 1) {
    //         //クリックしたタグのステータスを変更
    //         click_button.attr("like_product", "0");
    //         //クリックしたタグの子の要素を変更(表示されているハートの模様を書き換える)
    //         click_button.children().attr("class", "far fa-heart");
    //     }
    // });

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
                        console.log(data);
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

    function showMain() {
        $('#showMain').removeClass('d-none');
        $('#showReview').addClass('d-none');
    }

    function showReview() {
        $('#showMain').addClass('d-none');
        $('#showReview').removeClass('d-none');
    }
</script>
@endsection