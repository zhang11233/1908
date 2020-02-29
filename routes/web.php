<?php

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
//项目
Route::get('/','Index\IndexController@index');
Route::view('/login','index.login');
Route::view('/reg','index.reg');
Route::post('/login/checkOnly','Index\LoginsController@checkOnly');
Route::post('/login/checkOnly','Index\LoginsController@checkOnly');
Route::post('/login/sendReg','Index\LoginsController@sendReg');
Route::get('/user_index','Index\LoginsController@user_index');//测试cookie
Route::post('/regdo','Index\LoginsController@regdo');
Route::post('/logindo','Index\LoginsController@logindo');
Route::get('/proinfo/{id}','Index\GoodsController@index');
Route::get('/sencode','Index\LoginsController@sendCode');
Route::post('/car','Index\GoodsController@addcart');
Route::get('/cartlist','Index\GoodsController@cartList');


//Route::get('/brand/add','BrandController@add');
//Route::view('/brand/add','brand.add');

//Route::view('/category/add','category.add',['fid'=>'服装']);
//Route::get('/show','UserController@index');
//Route::get('/add','UserController@add');
//Route::post('/adddo','UserController@adddo')->name('do');
Route::prefix('people')->group(function(){
    Route::get('create','PeopleController@create');
    Route::post('store','PeopleController@store');
    Route::get('/','PeopleController@index');
    Route::get('destroy/{id}','PeopleController@destroy');
    Route::get('edit/{id}','PeopleController@edit');
    Route::post('update/{id}','PeopleController@update');
});

//Route::prefix('student')->middleware('checklogin')->group(function(){
//    Route::get('create','StudentController@create');
//    Route::post('store','StudentController@store')->name('store');
//    Route::get('index','StudentController@index');
//    Route::get('destroy/{id}','StudentController@destroy');
//    Route::get('edit/{id}','StudentController@edit');
//    Route::post('update/{id}','StudentController@update');
//});
//Route::get('/login','LoginController@login');
//Route::post('/logindo','LoginController@logindo');

Route::prefix('brand')->group(function(){
    Route::get('create','BrandController@create');
    Route::post('store','BrandController@store');
    Route::get('index','BrandController@index');
    Route::get('destroy/{id}','BrandController@destroy');
    Route::get('edit/{id}','BrandController@edit');
    Route::post('update/{id}','BrandController@update');
});
Route::prefix('article')->middleware('login')->group(function(){
    Route::get('create','ArticleController@create');
    Route::get('show/{id}','ArticleController@show');
    Route::post('store','ArticleController@store');
    Route::get('index','ArticleController@index');
    Route::get('destroy','ArticleController@destroy');
    Route::get('edit/{id}','ArticleController@edit');
    Route::post('update/{id}','ArticleController@update');
    Route::post('checkOnly','ArticleController@checkOnly');
});
Route::view('/article/login','article.login');
Route::post('/article/logindo','CheckController@logindo');

//Route::post('/logindo','LoginController@logindo');

Route::get('/cate/create','CateController@create');
Route::post('/cate/store','CateController@store');
Route::post('/cate/checkOnly','CateController@checkOnly');
Route::get('/cate/index','CateController@index');
Route::get('/cate/destroy/{id}','CateController@destroy');
Route::get('/cate/edit/{id}','CateController@edit');
Route::post('/cate/update/{id}','CateController@update');

Route::prefix('goods')->group(function(){
   Route::get('create','GoodsController@create');
   Route::post('checkOnly','GoodsController@checkOnly');
   Route::post('store','GoodsController@store');
   Route::get('index','GoodsController@index');
   Route::get('destroy','GoodsController@destroy');
   Route::get('edit/{id}','GoodsController@edit');
   Route::post('update/{id}','GoodsController@update');
});
Route::prefix('admin')->group(function(){
    Route::get('create','AdminController@create');
    Route::post('checkOnly','AdminController@checkOnly');
    Route::post('store','AdminController@store');
    Route::get('index','AdminController@index');
    Route::get('destroy','AdminController@destroy');
    Route::get('edit/{id}','AdminController@edit');
    Route::post('update/{id}','AdminController@update');
});

Route::view('/index','users.index')->middleware('logins');
//Route::view('/logins','users.logins');
//Route::post('/loginsdo','LoginsController@loginsdo');
Route::get('/indexs','UsersController@index')->middleware('logins');
Route::get('/destroy/{id}','UsersController@destroy')->middleware('logins');
Route::get('/create','UsersController@create')->middleware('logins');
Route::post('/store','UsersController@store')->middleware('logins');
