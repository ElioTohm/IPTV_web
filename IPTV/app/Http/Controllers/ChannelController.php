<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChannelController extends Controller
{
    // index function for main page
    public function index () 
    {
        return view('channels');
    }
}
