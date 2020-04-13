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
Route::get('/confirm/ad/{token}', 'AdConfirmationController@confirmAd')->name('confirm.ad');
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

    // ads
    Route::get('/ads/edit/{slug}', 'AdController@showAdEditingForm')->name('ads.edit');
    Route::post('/ads/edit', 'AdController@editAd')->name('ads.edit.post');
    // adblocker blocks ajax requests to /ads/images/upload/single
    Route::post('/posts/images/upload/single', 'AdController@uploadSingleImage')->name('ads.images.upload.single.post');
    Route::post('/posts/images/delete/single', 'AdController@deleteSingleImage')->name('ads.images.delete.single.post');
    Route::get('/posts/images/for/{adId}', 'AdController@getAdImages')->name('ads.images.get');
    Route::get('/my-ads', 'AdController@getLoggedInUserAds')->name('account.ads');
});

// Admin routes
Route::group(['middleware' => ['role:admin'], 'prefix' => 'dashboard'], function () {
    Route::get('/overview', 'PageController@showDashboard')->name('admin');
    Route::post('/review/ad', 'AdController@reviewAd')->name('admin.review.ad');
    Route::get('/toggle-suspension/ad/{adId}/{suspended}', 'AdController@toggleAdSuspension')->name('admin.toggle-suspension.ad');
    // categories
    Route::get('/categories', 'CategoryController@showCategoriesManagement')->name('admin.categories');
    Route::post('/categories/create', 'CategoryController@createCategory')->name('admin.categories.create.submit');
    Route::get('/categories/update/{id}', 'CategoryController@showEditCategoryForm')->name('admin.categories.update');
    Route::post('/categories/delete', 'CategoryController@deleteCategory')->name('admin.categories.delete');
    Route::post('/categories/update', 'CategoryController@updateCategory')->name('admin.categories.update.submit');
    // Users
    Route::get('/users', 'UserController@showUsers')->name('admin.users');
    // Users
    Route::get('/ads', 'AdController@showAds')->name('admin.ads');
    // Regions
    Route::get('/regions', 'RegionController@showRegionsManagement')->name('admin.regions');
    Route::get('/regions/update/{id}', 'RegionController@showEditRegionForm')->name('admin.regions.update');
    Route::post('/regions/update', 'RegionController@updateRegion')->name('admin.regions.update.submit');
    Route::post('/regions/create', 'RegionController@createRegion')->name('admin.regions.create.submit');
    Route::post('/regions/delete', 'RegionController@deleteRegion')->name('admin.regions.delete');
    Route::get('/regions/{id}', 'RegionController@showRegion')->name('admin.regions.show');
    // City
    Route::get('/cities/update/{id}', 'CityController@showEditCityForm')->name('admin.cities.update');
    Route::post('/cities/update/', 'CityController@updateCity')->name('admin.cities.update.submit');
    Route::post('/cities/create', 'CityController@createCity')->name('admin.cities.create.submit');
    Route::post('/cities/delete', 'CityController@deleteCity')->name('admin.cities.delete');


});