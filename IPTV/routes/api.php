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
Route::post('/registerDevice', 'ApiController@register');

Route::group(['middleware' => ['auth_client']], function()
{

    // testing route
    Route::get('/user', function (Request $request) {
        return 'tse';
    });

    // get channel
    Route::get('/channel' , 'ApiController@getChannel');

    // get client info
    Route::get('/clientInfo' , 'ApiController@getClientInfo');

});
