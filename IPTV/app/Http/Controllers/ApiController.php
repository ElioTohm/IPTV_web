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
        $channels = Channel::with('genres')->get(['id', 'name', 'stream', 'thumbnail']);
        $genres = Genre::get(['id', 'name']);
        return response()->json([
            'genres' => $genres,
            'channels' => $channels
        ]);
    }
}
