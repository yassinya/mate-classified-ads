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

// these routes can be accessed by anyone
Route::get('/', 'PageController@showHomePage')->name('home');
// ads
Route::get('/ads/submit', 'AdController@showAdSubmissionForm')->name('ads.create');
Route::post('/ads/submit', 'AdController@postAd')->name('ads.create.post');
Route::get('/ads/show/{slug}', 'AdController@showSingleAd')->name('ads.show.single');
// categories
Route::get('/categories/show/{slug}', 'CategoryController@showSingleCategory')->name('categories.show.single');

// Only non logged in users can access below routes
Route::middleware(['guest'])->group( function ()
{
    Route::get('/register', 'RegisterController@showRegisterPage')->name('register');
    Route::post('/register', 'RegisterController@register')->name('register.post');
    Route::get('/login', 'AuthenticationController@showLoginPage')->name('login');
    Route::post('/login', 'AuthenticationController@login')->name('login.post');
});

// Only logged in users can access below routes
Route::middleware(['auth'])->group( function ()
{
    Route::post('/logout', 'AuthenticationController@logout')->name('logout.post');
});

