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

        $channels = Channel::search($request->input('query'))->get();

        return $channels;
    }
}
