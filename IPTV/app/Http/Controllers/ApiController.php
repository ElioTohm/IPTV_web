<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use App\Genre;
use App\Client;
use App\Device;

class ApiController extends Controller
{
    // Get Channels
    public function getChannel (Request $request) 
    {
        $channels = Channel::with('genres')->get(['id', 'number', 'name', 'stream', 'thumbnail']);
        return $channels;
    }

    // Get Client Info
    public function getClientInfo (Request $request)
    {
        $device = Device::where('id', $request->input('id'))->first(['room']);

        $client = Client::where('room', $device->room)->first(["id","name","email","room","welcome_message","credit","debit"]);
        
        return $client;
    }
}
