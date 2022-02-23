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
Route::get('/user-verify', 'UserController@verify');
Route::get('/user-delete', 'UserController@delete');

Route::post('/upload-story', 'StoryController@upload');

Route::post('send-item-request', 'AppController@requestnew');
Route::get('/download', 'AppController@download')->middleware(['auth', 'verified']);
Route::get('/dwnlds', 'AppController@dwnlds');
Route::get('/downloadTransport', 'AppController@downloadTransport');
Route::get('/downloadCovidUpdate', 'AppController@downloadCovid');
Route::get('/downloadCovidUpdate', 'AppController@downloadCovid');
Route::get('/inv', 'AppController@inv');

//pages
Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/add-item', 'PagesController@add');
Route::get('/add-story', 'PagesController@addstory');
Route::get('/cart', 'PagesController@cart');
Route::get('/catalogue', 'PagesController@catalogue');
Route::get('/feedback', 'PagesController@feedback');
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
Route::get('/verify-emails', 'PagesController@verifyemails');
Route::get('/hr/{deets}', 'PagesController@hrdeets');
Route::get('/request-item', 'PagesController@newrequest')->middleware(['auth', 'verified']);
Route::get('/extra_net', 'PagesController@extranet')->middleware(['auth', 'verified']);
Route::get('/pk-overview', 'PagesController@pk_overview')->middleware(['auth', 'verified']);
Route::get('/tr-overview', 'PagesController@tr_overview')->middleware(['auth', 'verified']);
Route::get('/bo-monitoring', 'PagesController@bo_monitoring')->middleware(['auth', 'verified']);
Route::get('/tr-packing', 'PagesController@tr_packing')->middleware(['auth', 'verified']);
Route::get('/order-confirmation', 'PagesController@order_confirmation')->middleware(['auth', 'verified']);
Route::get('/packing-view', 'PagesController@pk_view')->middleware(['auth', 'verified']);
Route::get('/order-view', 'PagesController@order_view')->middleware(['auth', 'verified']);
Route::get('/freight-view', 'PagesController@freight_view')->middleware(['auth', 'verified']);
Route::get('/invoice', 'PagesController@invoice')->middleware(['auth', 'verified']);
Route::get('/rts', 'PagesController@rts')->middleware(['auth', 'verified']);
Route::get('/stock', 'PagesController@stock')->middleware(['auth', 'verified']);
Route::get('/rts-value', 'PagesController@rts_value')->middleware(['auth', 'verified']);
Route::get('/freight-reception', 'PagesController@freight_reception')->middleware(['auth', 'verified']);
//Route::get('/covid19', 'PagesController@covid')->middleware(['auth', 'verified']);

Route::get('/language', 'SessionController@language');
Route::get('/currency', 'SessionController@currency');
Route::get('/upload', 'SessionController@upload');
Route::get('/list', 'SessionController@list');
Route::get('/notShowPics', 'SessionController@notShowPics');
Route::get('/showPics', 'SessionController@showPics');
Route::post('/upload-images', 'SessionController@uploadImages');
Route::get('/oc', 'SessionController@oc');
Route::get('/country', 'SessionController@country');

Route::resource('article', 'ArticleController');
Route::post('/uploadPics', 'ArticleController@uploadPics');
Route::post('/deletePics', 'ArticleController@deletePics');
Route::post('/import', 'ArticleController@import');

Route::post('/carting', 'CartController@carting');
Route::post('/cartNoPic', 'CartController@cartNoPic');
Route::post('/update', 'CartController@update');
Route::get('/decarting/{id}', 'CartController@decarting');
Route::get('/clear', 'CartController@clear');
Route::get('/exportUf', 'CartController@exportUf')->middleware(['auth', 'verified']);
Route::post('/exportIr', 'CartController@exportIr');
Route::post('/exportRfq', 'CartController@exportRfq')->middleware(['auth', 'verified']);

Route::post('/request-supply', 'EmailController@requestSupply')->middleware(['verified']);

Route::post('/importDonations', 'DonationController@importDonations');
Route::get('/exportDonations', 'DonationController@exportDonations');

Auth::routes(['verify' => true]);

Route::get('/home', 'PagesController@index')->name('home');