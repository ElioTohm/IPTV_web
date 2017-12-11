<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MovieRequest;
use App\Movie;


class VodController extends Controller
{
    // index
    public function index () 
    {
    	return view('vod');
    }

    // insert Movies () 
    public function addMovie (MovieRequest $request) 
    {

    }
    
}
