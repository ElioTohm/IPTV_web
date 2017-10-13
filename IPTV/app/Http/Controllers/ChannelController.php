<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use App\Genre;
use App\StreamType;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Requests\ChannelRequest;

class ChannelController extends Controller
{
    /**
     * return all channels
     */
    public function getChannels () 
    {
        $channels = Channel::with('genres', 'streamtype')
                            ->select(['id', 'number', 'name', 'stream', 'thumbnail', 'stream_type'])
                            ->paginate(env('ITEM_PER_PAGE'));
        
        $genres = Genre::get(['id', 'name']);

        $stream_types = StreamType::get(['id','name']);
        
        return response()->json([
            'genres' => $genres,
            'channels' => $channels,
            'stream_types' => $stream_types,
        ]);
    }

    public function addChannel (ChannelRequest $request) 
    {
        $channel = new Channel();
        $channel->number = $request->input('number');
        $channel->name = $request->input('name');
        $channel->stream = $request->input('stream');
        $channel->stream_type = $request->input('stream_type');
        $this->checkThumbnail($channel, $request->get('thumbnail'), $request->input('name'), TRUE);
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
        $channel->stream_type = $request->input('stream_type');
        $this->checkThumbnail($channel, $request->get('thumbnail'), $request->input('name'), FALSE);
        $channel->save();
        $channel->genres()->sync($request->input('genres'));
    }

    public function deleteChannel ($id) 
    {
        $channel = Channel::find($id);
        $channel->delete();
    }

    private function checkThumbnail ($channel, $image, $name, $addchannel) {
        if (substr( $image, 0, 10 ) === "data:image") {
            Image::make($image)->encode('png', 50)->save(public_path('images/device/channels') . $name . '.png');
            $channel->thumbnail = $name . '.png';
        }
    }
}
