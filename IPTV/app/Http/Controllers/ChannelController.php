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
        $channels = Channel::get(['id', 'name', 'stream', 'thumbnail', 'description']);
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

    public function updateChannel ($id, ChannelRequest $request) 
    {
        $channel = Channel::find($id);

        $channel->name = $request->input('name');
        $channel->stream = $request->input('stream');
        $channel->description = $request->input('description');
        $channel->thumbnail = $request->input('thumbnail');

        $channel->save();
    }

    public function deleteChannel ($id) 
    {
        $channel = Channel::find($id);
        $channel->delete();

    }
}
