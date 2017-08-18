<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use App\Genre;
use App\Http\Requests\ChannelRequest;

class ChannelController extends Controller
{
    /**
     * return all channels
     */
    public function getChannels () 
    {
        $channels = Channel::with('genres')->get(['id', 'number', 'name', 'stream', 'thumbnail']);
        $genres = Genre::get(['id', 'name']);
        return response()->json([
            'genres' => $genres,
            'channels' => $channels
        ]);
    }

    public function addChannel (ChannelRequest $request) 
    {
        $channel = new Channel();
        $channel->number = $request->input('number');
        $channel->name = $request->input('name');
        $channel->stream = $request->input('stream');
        $channel->thumbnail = $request->input('thumbnail');
        $channel->save();

        $channel->genres()->sync($request->input('genres'));

        return $channel;
    }

    public function updateChannel ($id, ChannelRequest $request) 
    {
        $channel = Channel::find($id);
        
        $channel->number = $request->input('number');
        $channel->name = $request->input('name');
        $channel->stream = $request->input('stream');
        $channel->thumbnail = $request->input('thumbnail');

        $channel->save();

        $channel->genres()->sync($request->input('genres'));
    }

    public function deleteChannel ($id) 
    {
        $channel = Channel::find($id);
        $channel->delete();

    }
}
