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

Route::group(['middleware' => ['auth:api']], function()
{
    // get channel
    Route::get('/channel' , 'ApiController@getChannel');

    // testing route
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});