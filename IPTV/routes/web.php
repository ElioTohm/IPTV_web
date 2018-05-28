<?php

use App\Notifications\DeviceNotification;
use App\User;
use Illuminate\Http\Request;

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
    return redirect('hotelclientindex');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    
    Route::get('/changepassword', function () {
        return view("auth.passwords.reset");
    });

    Route::post('/resetpass', function (Request $request) {
        $user_id = Auth::user()->id;
        $obj_user = User::find($user_id);
        if ($request['password_confirmation'] == $request['password']) {
            $obj_user->password = Hash::make($request['password_confirmation']);
            $obj_user->save(); 
            return redirect('hotelclientindex');
        }
    });
    
    Route::get('/{vue_capture?}', function () {
        return response()->view('home');
    })->where('vue_capture', '\w*index\b');

    // section Resource route
    Route::resource('sections', 'SectionController');
    
    // Service Resource route
    Route::resource('services', 'ServiceController');

    // SectionItem Resource route
    Route::resource('sectionitem', 'SectionItemController');

    Route::get('/genreSTypes', 'VodController@getGenresNStreamTypes');
    /**
     * admin route to set app settings 
     */
    Route::get('/admin/launcherapp', 'AdminController@getLauncherApp')
            ->middleware('check_admin');
    Route::post('/admin/launcherapp', 'AdminController@updateLauncherApp')
            ->middleware('check_admin');

    /**
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
     * VOD route 
     */
    Route::get('/movies', 'VodController@getMovies');
    Route::post('/movie', 'VodController@addMovie');
    Route::put('/movie/{id}', 'VodController@updateMovie');
    Route::delete('/movie/{id}', 'VodController@deleteMovie');
    
    /**
     * Search route
     */
    Route::get('/search', 'SearchController@search');

    /* 
    * Push notifcation routes
    */
    // notification route
    Route::get('/clientnotification/{id}', 'ClientController@sendNotification');

    Route::get('/record/{id}', 'JobsController@RecordStream');

    /*
     *  Job Routes 
     */
    Route::get('/catchup/{channel_id}/{catchup_time}', 'ChannelController@StreamToHLSconvert');
    Route::get('/disablecatchup/{channel_id}', 'ChannelController@setOriginalStream');
});