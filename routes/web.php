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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/shop', 'ShopController@index');
Route::get('/shop/create', 'ShopController@create');
Route::post('/shop', 'ShopController@store');
Route::get('/shop/{shopId}/edit', 'ShopController@edit');
Route::post('/shop/{shopId}', 'ShopController@update');
Route::post('/shop', 'ShopController@destroy');
