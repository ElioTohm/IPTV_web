<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use App\Http\Requests\ChannelRequest;

class ChannelController extends Controller
{
    /**
     * return all channels
     */
    public function getChannels () 
    {
        $channels = Channel::all();
        return $channels;
    }

    public function addChannel (ChannelRequest $request) 
    {
        $channel = new Channel();
        $channel->name = $request->input('name');
        $channel->stream = $request->input('stream');
        $channel->description = $request->input('description');
        $channel->thumbnail = $request->input('thumbnail');
        $channel->save();

        return $channel;
    }
}
