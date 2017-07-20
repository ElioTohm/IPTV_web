<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| API route to handle mobile requests
|
*/

Route::group(['middleware' => ['auth:api']], function () {

    // get user info
    Route::get('/user', function (Request $request) {
	    return $request->user();
	});

});

Route::get('/channels', 'APIChannelController@getChannelInfo');