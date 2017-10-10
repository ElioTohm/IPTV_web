<?php

use Illuminate\Http\Request;

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
Route::get('/registerDevice', 'ApiController@register');

Route::group(['middleware' => 'auth:api'], function()
{
    // get channel
    Route::get('/channel' , 'ApiController@getChannel');

    // get client info
    Route::get('/clientInfo' , 'ApiController@getClientInfo');
});
