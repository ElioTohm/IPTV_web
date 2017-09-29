<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use App\Device;
use App\Client;

class SearchController extends Controller
{

    /**
     * Search Controller 
     */
    public function search(Request $request){

        // switch case that uses the correct model respective to the model sent in the request
        switch ($request->input('model')) {
            // use Client model
            case 'Channel':
                return Channel::search($request->input('query'))->get();
            
            //  use Devices model
            case 'Device':
                return Device::search($request->input('query'))->get();

            //  use Clients model
            case 'Client':
                return Client::search($request->input('query'))->get();
            
            default:
                $model = [];
                return $model;
        }        
    }
}
