<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Channel;

class ApiController extends Controller
{
    // Get Channels
    public function getChannel (Request $request) 
    {
        return Channel::get(['id', 'name', 'stream', 'thumbnail', 'description']);
    }
}
