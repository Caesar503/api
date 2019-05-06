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
Route::get('/api/userinfo','UserApiController@userinfo');
//post-》application/x-www-form-urlencoded    &&&&&&&&&&& form-data
Route::post('/test/user','UserApiController@user_post');
//post-》raw
Route::post('/test/user_raw','UserApiController@user_post_r');