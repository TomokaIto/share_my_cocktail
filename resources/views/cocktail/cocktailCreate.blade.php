@extends('layouts.app')

@section('content')
<div class="post">
    <div class="container">
        <div class="row justify-content-center g-3">
            <h4>オリジナルカクテル投稿</h4>
            <div class="contentsForm mt-3">
                <p><span class="text-danger">*</span> は入力必須項目</p>
                <div id="message"></div>
                <form enctype="multipart/form-data" id="form" action="/cocktailPost" method="post" name="form">
                    @csrf
                    <div>
                        カクテル名<span class="text-danger">*</span>
                        @if ($errors->has('cocktail_name'))
                        <div class="alert alert-danger">
                            <font color="red">{{$errors->first('cocktail_name')}}</font>
                        </div>
                        @endif
                        <input id="cocktail_name" type="text" name="cocktail_name" class="rounded bg-dark text-light" value="{{ old('cocktail_name', ($date['cocktail_name'] ?? '')) }}" placeholder=""><br><br>
                    </div>
                    <div>
                        ジャンル<span class="text-danger">*</span>
                        @if ($errors->has('genre'))
                        <div class="alert alert-danger">
                            <font color="red">{{$errors->first('genre')}}</font>
                        </div>
                        @endif
                        <!-- <input id="genre" type="text" name="genre" value="{{ old('genre', ($date['genre'] ?? '')) }}" placeholder="" ><br><br> -->
                        <select name="genre" class="rounded bg-dark text-light">
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
                        </select><br><br>
                    </div>
                    <div>
                        アルコール度数<span class="text-danger">*</span>
                        @if ($errors->has('degree'))
                        <div class="alert alert-danger">
                            <font color="red">{{$errors->first('degree')}}</font>
                        </div>
                        @endif
                        <!-- <input id="degree" type="text" name="degree" value="{{ old('degree', ($date['degree'] ?? '')) }}" placeholder=""><br><br> -->
                        <select name="degree" class="rounded bg-dark text-light">
                            <option value="">選択</option>
                            <option>弱い</option>
                            <option>普通</option>
                            <option>強い</option>
                        </select><br><br>
                    </div>
                    <div>
                        テイスト<span class="text-danger">*</span>
                        @if ($errors->has('taste'))
                        <div class="alert alert-danger">
                            <font color="red">{{$errors->first('taste')}}</font>
                        </div>
                        @endif
                        <!-- <input id="taste" type="text" name="taste" value="{{ old('taste', ($date['taste'] ?? '')) }}" placeholder=""><br><br> -->
                        <select name="taste" class="rounded  bg-dark text-light">
                            <option value="">選択</option>
                            <option>甘口</option>
                            <option>中甘口</option>
                            <option>辛口</option>
                        </select><br><br>
                    </div>
                    <div>
                        <p>材料<span class="text-danger">*</span></p>
                        @if ($errors->has('material'))
                        <div class="alert alert-danger">
                            <font color="red">{{$errors->first('material')}}</font>
                        </div>
                        @endif
                        <textarea id="material" name="material" cols="120" rows="5" wrap="off" style="resize: none;" class="rounded bg-dark text-light">{{ old('material', ($date['material'] ?? '')) }}</textarea><br><br>
                    </div>
                    <div>
                        <p id="make">作り方<span class="text-danger">*</span></p>
                        @if ($errors->has('make'))
                        <div class="alert alert-danger">
                            <font color="red">{{$errors->first('make')}}</font>
                        </div>
                        @endif
                        <textarea id="make" name="make" cols="120" rows="12" wrap="off" style="resize: none;" class="rounded bg-dark text-light">{{ old('make', ($date['make'] ?? '')) }}</textarea><br><br>
                    </div>
                    <div>
                        <p id="recommends">おすすめポイント</p>
                        @if ($errors->has('recommends'))
                        <div class="alert alert-danger">
                            <font color="red">{{$errors->first('recommends')}}</font>
                        </div>
                        @endif
                        <textarea id="recommends" name="recommends" cols="120" rows="5" wrap="off" style="resize: none;" class="rounded bg-dark text-light">{{ old('recommends', ($date['recommends'] ?? '')) }}</textarea><br><br>
                    </div>
                    <div class="mb-3">
                        カクテルの画像<br>
                        <input type="file" class="form-file-label rounded" name="image" accept="image/jpeg,image/png" class="rounded bg-dark"><br><br>
                    </div>
                    <input type="hidden" name="submitted" value="true">
                    <button type="submit" class="btn btn-dark">送信</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection