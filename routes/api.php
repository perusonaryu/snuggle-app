<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Broadcast::routes(['middleware' => ['auth:sanctum']]);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return response()->json(['user' => $request->user()]);
    })->name('api.user');
    Route::post('logout', 'Auth\Api\LoginController@logout')->name('api.logout');
    Route::put('/user/update','UserController@update')->name('user.update');

    
});
Route::post('register', 'Auth\Api\RegisterController@register')->name('api.register');
Route::post('login', 'Auth\Api\LoginController@login')->name('api.login');

//猫情報登録
Route::post('cat/register','CatController@register')->name('cat.register');
Route::get('cat/mydata/{id}','CatController@catslistget')->name('cat.get');
Route::get('cat/edit/{id}','CatController@edit')->name('cat.edit');
Route::put('cat/update','CatController@update')->name('cat.update');
Route::delete('cat/delete/{cat_id}','CatController@delete')->name('cat.delete');





//猫掲載者の情報を取得
Route::get('posted/user/detail/{id}','UserController@detail');


Route::get('cats/topdata','CatController@topget');
Route::get('cats/data','CatController@get');
Route::get('cat/detail/{id}','CatController@detail');

//お気に入り猫情報取得
Route::get('favorite/cats/{id}','CatController@favoriteCatsGet');

//お気に入り
Route::post('cats/like/check','LikeController@check');
Route::post('cat/like','LikeController@like');
Route::post('cat/unlike','LikeController@unlike');


//メッセージ機能
Route::get('messagelist/{id}' ,'MessageRoomController@index');
Route::get('messages/{user_id_1}/{user_id_2}', 'MessageController@fetchMessages');
Route::post('send', 'MessageController@sendMessage');
Route::get('latestmessage/{user_id_1}/{user_id_2}','MessageController@latestMessageGet');


//検索機能
Route::get('search','CatController@search');



