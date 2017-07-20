<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Channel;

class APIChannelController extends Controller
{
    // list channel information
    public function getChannelInfo (Request $request)
    {	
    	$channels = Channel::get(['id', 'name', 'description']);

    	return $channels;
    }
}
