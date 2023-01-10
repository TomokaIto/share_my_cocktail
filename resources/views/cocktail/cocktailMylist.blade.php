@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> -->
<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity=" sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>


<!-- <h2 class="text-center">Share my Cocktail</h2><br> -->
<div class="row justify-content-center w-100">
    <div class="col-8 mt-5">
        <!-- @if(auth()->user())
        <div class="d-flex justify-content-between">
            <a class="btn btn-dark" href="/cocktailMylist" role="button">投稿一覧</a>
            <a class="btn btn-dark" href="/cocktailCreate" role="button">新規投稿</a>
            <a class="btn btn-dark" href="/cocktailMyfavorite" role="button">お気に入り一覧</a>
        </div><br>
        @endif
        <div class="d-flex align-items-center justify-content-center">
            <div class="text-center w-25 mb-3 text-dark rounded p-2" style="background-color: rgba(255, 255, 255, 0.662);">
                自分の好きなものを共有して<br>お気に入りのカクテルを探そう
            </div><br>
        </div> -->
        <div>
            <div class="card bg-transparent border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center">
                        <h4 class="card-title text-center text-light w-25 mb-3 p-2 rounded" style="background-color: rgba(128, 128, 128, 0.8);">投稿一覧</h4>
                    </div><br>
                    
                    <div id="post-table">

                        <div class="container">

                            <div class="row justify-content-center">

                                @foreach($posts as $post)
                                <div class="card mb-3 w-100 text-left h-25" style="max-width: 540px; background-color: rgba(192, 192, 192, 1); color:black;">
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
                                                    <a href="/cocktailShow/{{$post->id}}" class="" style="color: black;">{{ $post->cocktail_name }}</a>
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
                <div class="d-flex align-items-center justify-content-center">
                    <a href="#" class="btn btn-danger btn-sm btn-block mb-3 w-25" role="button" onclick="history.back(-1);return false;">BACK</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection