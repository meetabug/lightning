<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
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
Auth::routes(['reset' => false]);

// User
Route::get('user/setting','User\UserController@edit');
Route::put('user','User\UserController@update');
Route::delete('user','User\UserController@destroy');
Route::get('user/{user}','User\ProfileController@index');
Route::get('user/{user}/likes','User\ProfileController@likes');

// Posts
Route::resource('posts', 'Post\PostController')->except('show');
Route::get('posts/drafts', 'Post\PostController@drafts');
Route::get('posts/{post}', 'Post\ShowPost');
Route::post('upload/mavon-editor-image','UploadController@mavonEidtorImage');
Route::post('posts/{post}/like', 'Post\PostController@like');

Route::get('/', 'Post\ShowPostList');

Route::get('/about', function () {
    return Inertia::render('About');
});

