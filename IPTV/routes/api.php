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
	/**
	 * Section Protect Ott streams 
	 * section is currently under testing 
	 */
    Route::get('/stream/{video_id}/play', function ($video_id) {
		return response()->download('/var/www/storage/app/public/movies/videos/' . $video_id . '/720p.m3u8', 
									'play.m3u8', 
									['Content-Type' => 'application/octet-stream']);
	});

	Route::get('/stream/{video_id}/{file}', function ($video_id, $file) {
	    return response()->download('/var/www/storage/app/public/movies/videos/'. $video_id .'/'. $file, 
	    							'play.ls', 
	    							['Content-Type' => 'application/octet-stream']);
	})->where('file', '\w*.ts\b');
	// end section

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

	// provide weather to client
	Route::get('/weather', 'ApiController@getWeather');
});
