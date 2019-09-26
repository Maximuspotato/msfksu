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
Route::post('/request-new', 'AppController@requestnew');
Route::get('/download', 'AppController@download')->middleware(['auth', 'verified']);

//pages
Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/add-item', 'PagesController@add');
Route::get('/cart', 'PagesController@cart');
Route::get('/catalogue', 'PagesController@catalogue');
Route::get('/contacts', 'PagesController@contacts');
Route::get('/downloads', 'PagesController@downloads');
Route::get('/edit', 'PagesController@edit');
Route::get('/hr', 'PagesController@hr');
Route::get('/item', 'PagesController@item');
Route::get('/search', 'PagesController@search');
Route::get('/services', 'PagesController@services');
Route::get('/favorites', 'PagesController@favorites');
Route::get('/history', 'PagesController@history');
Route::get('/getfam', 'PagesController@getfam');
Route::get('/hr/{deets}', 'PagesController@hrdeets');
Route::get('/new-request', 'PagesController@newrequest')->middleware(['auth', 'verified']);

Route::get('/language', 'SessionController@language');
Route::get('/currency', 'SessionController@currency');
Route::get('/upload', 'SessionController@upload');
Route::get('/tc', 'SessionController@tc');
Route::post('/upload-images', 'SessionController@uploadImages');

Route::resource('article', 'ArticleController');
Route::post('/uploadPics', 'ArticleController@uploadPics');
Route::post('/deletePics', 'ArticleController@deletePics');
Route::post('/import', 'ArticleController@import');

Route::post('/carting', 'CartController@carting');
Route::post('/update', 'CartController@update');
Route::get('/decarting/{id}', 'CartController@decarting');
Route::get('/clear', 'CartController@clear');
Route::get('/exportUf', 'CartController@exportUf')->middleware(['auth', 'verified']);
Route::post('/exportIr', 'CartController@exportIr');
Route::post('/exportRfq', 'CartController@exportRfq')->middleware(['auth', 'verified']);

Route::post('/request-supply', 'EmailController@requestSupply')->middleware(['verified']);

Auth::routes(['verify' => true]);

Route::get('/home', 'PagesController@index')->name('home');