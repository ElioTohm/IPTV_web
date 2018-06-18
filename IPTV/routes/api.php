<?php

use Illuminate\Http\Request;

use App\Channel;
use App\Purchase;

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
	Route::get('/stream/keys/{stream_id}' , function ($stream_id) {
		return response()->download(storage_path('app/private/keys/')."$stream_id.key");
	});

	// check for update
	Route::get('/launcherUpdate', 'ApiController@launcherUpdateCheck');

	// get channel
	Route::get('/channel' , 'ApiController@getChannel');

	// movies route
	Route::get('/vodmovies', 'ApiController@getVODStreams');

	// get client info
	Route::get('/clientInfo' , 'ApiController@getClientInfo');

	// client purchase route
	Route::post('/clientpurchase', 'ApiController@clientPurchase');

	// section route
	Route::get('/sections', 'ApiController@getSections');

	// services client
	Route::get('/services', 'ApiController@getServices');

	// provide weather to client
	Route::get('/weather', 'ApiController@getWeather');
});
