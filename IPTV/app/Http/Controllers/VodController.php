<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VodController extends Controller
{
    // index
    public function index () {
    	return view('vod');
    }

    
}
