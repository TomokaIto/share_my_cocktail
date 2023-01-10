<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/cocktailIndex');
});

\Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/cocktailCreate', [App\Http\Controllers\CocktailController::class, 'cocktailCreate']);
// Route::post('/cocktailPost', [App\Http\Controllers\CocktailController::class, 'cocktailPost']);
Route::get('/cocktailIndex', [App\Http\Controllers\CocktailController::class, 'cocktailIndex']);
Route::get('/cocktailSearch', [App\Http\Controllers\CocktailController::class, 'cocktailSearch']);

Route::group(['middleware' => 'auth'], function () {
    // カクテル新規投稿
    Route::get('/cocktailCreate', [App\Http\Controllers\CocktailController::class, 'cocktailCreate']); 
    Route::post('/cocktailPost', [App\Http\Controllers\CocktailController::class, 'cocktailPost']);
    Route::get('/cocktailEdit/{id}', [App\Http\Controllers\CocktailController::class, 'cocktailEdit']);
    Route::post('/cocktailUpdate', [App\Http\Controllers\CocktailController::class, 'cocktailUpdate']);
    Route::post('/cocktailDelete/{id}', [App\Http\Controllers\CocktailController::class, 'cocktailDelete']);
    Route::get('/cocktailMylist', [App\Http\Controllers\CocktailController::class, 'cocktailMylist']);
    Route::get('/cocktailMyfavorite', [App\Http\Controllers\CocktailController::class, 'cocktailMyfavorite']);

    // お気に入り
    Route::get('mylists/mypost',[App\Http\Controllers\MyListController::class, 'mypost'])->name('mylists.mypost');
    Route::get('mylists/index',[App\Http\Controllers\MyListController::class, 'index'])->name('mylists.index');
    Route::post('mylists/store',[App\Http\Controllers\MyListController::class, 'store'])->name('mylists.store');
    Route::post('mylists/delete/{id}',[App\Http\Controllers\MyListController::class, 'delete'])->name('mylists.delete');

    Route::get('mylists/mylist','MyListController@mylist')->name('mylists.mylist');

    // レビュー
    Route::post('review',[App\Http\Controllers\CocktailController::class, 'review'])->name('review');
    Route::post('reviewDelete/{id}',[App\Http\Controllers\CocktailController::class, 'reviewDelete'])->name('reviewDelete');

    // ユーザ一覧
    Route::get('/userIndex', [App\Http\Controllers\CocktailController::class, 'userIndex']);
    Route::post('/userDelete/{id}', [App\Http\Controllers\CocktailController::class, 'userDelete']);
});
Route::get('/cocktailShow/{id}',[App\Http\Controllers\CocktailController::class, 'cocktailShow']);

Route::post('like_product',[App\Http\Controllers\LikeController::class, 'like_product'])->name('like_product');


// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
