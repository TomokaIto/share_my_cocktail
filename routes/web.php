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

Route::group(['middleware' => 'auth'], function () {
    //カクテル新規投稿
    Route::get('/cocktailCreate', [App\Http\Controllers\CocktailController::class, 'cocktailCreate']); 
    Route::post('/cocktailPost', [App\Http\Controllers\CocktailController::class, 'cocktailPost']);
    Route::get('/cocktailEdit/{id}', [App\Http\Controllers\CocktailController::class, 'cocktailEdit']);
    Route::post('/cocktailUpdate', [App\Http\Controllers\CocktailController::class, 'cocktailUpdate']);
    Route::post('/cocktailDelete/{id}', [App\Http\Controllers\CocktailController::class, 'cocktailDelete']);
    //お気に入り
    Route::get('mylists/mypost',[App\Http\Controllers\MyListController::class, 'mypost'])->name('mylists.mypost');
    Route::get('mylists/index',[App\Http\Controllers\MyListController::class, 'index'])->name('mylists.index');
    Route::post('mylists/store',[App\Http\Controllers\MyListController::class, 'store'])->name('mylists.store');
    Route::post('mylists/delete/{id}',[App\Http\Controllers\MyListController::class, 'delete'])->name('mylists.delete');

    Route::get('mylists/mylist','MyListController@mylist')->name('mylists.mylist');

    Route::post('like_product',[App\Http\Controllers\LikeController::class, 'like_product'])->name('like_product');
});
Route::get('/cocktailShow/{id}',[App\Http\Controllers\CocktailController::class, 'cocktailShow']);



// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
