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

    // get Movies  
    public function getMovies (MovieRequest $request) 
    {
    	return Movie::paginate(15);
    }	
    
}
