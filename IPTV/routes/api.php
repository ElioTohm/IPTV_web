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
Route::get('/vodmovies', 'ApiController@getVODStreams');

Route::group(['middleware' => 'auth:api'], function()
{
	/**
	 * Section Protect Ott streams 
	 * section is currently under testing 
	 */
	Route::get('/stream/channel/{channel_id}/play', function ($channe_id) {
		return response()->download('/var/www/storage/app/public/streams/'.$channe_id.'/master.m3u8');
	});

	Route::get('/stream/channel/{channe_id}/{file}', function ($channe_id, $file) {
		return response()->download('/var/www/storage/app/public/streams/'. $channe_id .'/'. $file);
	})->where('file', '\w*(.ts|.m3u8)\b');
	// end section
	
	// check for update
	Route::get('/launcherUpdate', 'ApiController@launcherUpdateCheck');

	// get channel
	Route::get('/channel' , 'ApiController@getChannel');

	// movies route
	

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
