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

Route::get('user/setting','User\UserController@edit');
Route::put('user','User\UserController@update');

Route::get('/', function () {
    return Inertia::render('HelloWorld',[
        'name' => 'demo',
    ]);
});

Route::get('/about', function () {
    return Inertia::render('About');
});

