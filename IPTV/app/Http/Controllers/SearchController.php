<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;

class SearchController extends Controller
{

    /**
     * Search Controller 
     */
    public function search(Request $request){

        switch ($request->input('model')) {
            case 'Channel':
                return Channel::search($request->input('query'))->get();

            default:
                $model = [];
                return $model;
        }        
    }
}
