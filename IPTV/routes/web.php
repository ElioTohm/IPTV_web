<?php

use App\Events\ClientSettingsEvent;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::middleware(['auth'])->group(function () {
    /* 
     * Channels controller and view
     */
    Route::get('/channel', 'ChannelController@getChannels');
    Route::post('/channel', 'ChannelController@addChannel');
    Route::put('/channel/{id}', 'ChannelController@updateChannel');
    Route::delete('/channel/{id}', 'ChannelController@deleteChannel');

    /*
     * Devices Controller 
     */
    Route::get('/device', 'DeviceController@getDevices');
    Route::post('/device', 'DeviceController@addDevice');
    Route::put('/device/{id}', 'DeviceController@updateDevice');
    Route::delete('/device/{id}', 'DeviceController@deleteDevice');

    /*
     * Client Controller 
     */
     Route::get('/client', 'ClientController@getClients');
     Route::post('/client', 'ClientController@addClient');
     Route::put('/client/{id}', 'ClientController@updateClient');
     Route::delete('/client/{id}', 'ClientController@deleteClient');


    /**
     * Search route
     */
    Route::get('/search', 'SearchController@search');

    /* 
    * Push notifcation routes
    */
    // notification route
    Route::get('/clientnotification/{id}', 'ClientController@sendNotification');

});