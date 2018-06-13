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




Route::get('post/{post}/comments', 'CommentController@index');

Route::middleware('auth:api')->group(function () {
	Route::post('posts/{post}/comment', 'CommentController@store');
});


Route::resource('/posts', 'PostController');

Auth::routes();