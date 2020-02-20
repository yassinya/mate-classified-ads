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

Route::get('/', 'PageController@showHomePage')->name('home');
Route::post('/register', 'RegisterController@register')->name('register.post');
Route::post('/login', 'AuthenticationController@login')->name('login.post');
Route::post('/logout', 'AuthenticationController@logout')->name('logout.post');
