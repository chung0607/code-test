<?php

// Not related to route
//Blade::setContentTags('<%', '%>');        // for variables and all things Blade
//Blade::setEscapedContentTags('<%%', '%%>');   // for escaped data

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

Route::get('/', 'IndexController@index');

Auth::routes();

Route::get('/backend', 'BackendController@index');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/products', 'ProductController@index');
    Route::get('/product/create', 'ProductController@create');
    Route::get('/product/edit/{id}', 'ProductController@edit');
    Route::post('/product/store', 'ProductController@store');
    Route::post('/product/update/{id}', 'ProductController@update');
    Route::delete('/product/{id}', 'ProductController@destroy');


    Route::get('/users', 'UserController@index');
    Route::get('/user/create', 'UserController@create');
    Route::get('/user/edit/{id}', 'UserController@edit');
    Route::post('/user/store', 'UserController@store');
    Route::post('/user/update/{id}', 'UserController@update');
    Route::delete('/user/{id}', 'UserController@destroy');
});

Route::get('/product', 'ProductController@get');
Route::get('/user', 'UserController@get');

Route::get('/cart', 'CartController@index');
Route::post('/cart_item', 'CartController@add');
Route::get('/cart_item', 'CartController@get');
Route::post('/cart_item/{id}', 'CartController@update');
Route::delete('/cart_item/{id}', 'CartController@destroy');
