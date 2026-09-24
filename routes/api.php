<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/planning-data', function () {
    $path = public_path('files/Planning.csv');    
    if (!file_exists($path)) {        abort(404);    }    
    return Response::make(file_get_contents($path), 200, [        
        'Content-Type' => 'text/plain; charset=UTF-8',        
        'Access-Control-Allow-Origin' => '*',        
        'Cache-Control' => 'public, max-age=300',        
        'X-Robots-Tag' => 'noindex, nofollow',    
    ]);
});

Route::get('/stock-data', function () {
    $path = public_path('files/Stock.csv');    
    if (!file_exists($path)) {        abort(404);    }    
    return Response::make(file_get_contents($path), 200, [        
        'Content-Type' => 'text/plain; charset=UTF-8',        
        'Access-Control-Allow-Origin' => '*',        
        'Cache-Control' => 'public, max-age=300',        
        'X-Robots-Tag' => 'noindex, nofollow',    
    ]);
});

Route::get('/Product-data', function () {
    $path = public_path('files/Product.csv');    
    if (!file_exists($path)) {        abort(404);    }    
    return Response::make(file_get_contents($path), 200, [        
        'Content-Type' => 'text/plain; charset=UTF-8',        
        'Access-Control-Allow-Origin' => '*',        
        'Cache-Control' => 'public, max-age=300',        
        'X-Robots-Tag' => 'noindex, nofollow',    
    ]);
});