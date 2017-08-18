<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use App\Genre;

class ApiController extends Controller
{
    // Get Channels
    public function getChannel (Request $request) 
    {
        $channels = Channel::with('genres')->get(['id', 'number', 'name', 'stream', 'thumbnail']);
        return $channels;
    }
}
