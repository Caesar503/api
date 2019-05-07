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
//get
Route::get('/api/userinfo','UserApiController@userinfo')->middleware(['gltenmin','checklogin']);
//post-》application/x-www-form-urlencoded    &&&&&&&&&&& form-data
Route::post('/test/user','UserApiController@user_post');
//post-》raw
Route::post('/test/user_raw','UserApiController@user_post_r');


//注册
Route::post('/test/reg','UserApiController@reg');
//登录
Route::post('/test/login','UserApiController@login');


//生成器
Route::get('/test/aaa','UserApiController@aaa');
//创建闭包
Route::get('/test/bbb','UserApiController@bbb');

//创建资源控制器
Route::resource('/goods',GoodsController::class);