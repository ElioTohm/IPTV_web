<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;

class ChannelController extends Controller
{
    // index function for main page
    public function getchannels () 
    {
        $channels = Channel::all();
        return $channels;
    }
}
