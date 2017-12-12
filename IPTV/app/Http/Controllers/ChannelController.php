<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use App\Genre;
use App\StreamType;
use App\Stream;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Requests\ChannelRequest;

class ChannelController extends Controller
{
    /**
     * return all channels
     */
    public function getChannels () 
    {
        // $channels = Stream::where('channel', '>', 0)->with('channel.genres')->paginate(env('ITEM_PER_PAGE'));
        $channels = Channel::with('genres', 'stream.type')
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
        // create stream object
        $stream = new Stream();
        $stream->vid_stream = $request->input('stream');
        $stream->type = $request->input('stream_type');
        
        // create channel object
        $channel = new Channel();
        $channel->number = $request->input('number');
        $channel->name = $request->input('name');
        $this->checkThumbnail($channel, $request->get('thumbnail'), $request->input('name'), TRUE);
        $channel->save();
        $channel->genres()->sync($request->input('genres'));
        $stream->channel = $channel->id;
        $stream->save();
        return $channel;
    }

    public function updateChannel ($id, ChannelRequest $request) 
    {
        $channel = Channel::find($id);
        //update stream table
        $stream = $channel->stream()->first();
        $stream->vid_stream = $request->input('stream');
        $stream->type = $request->input('stream_type');
        $stream->save();
        // update channel table
        $channel->number = $request->input('number');
        $channel->name = $request->input('name');
        $this->checkThumbnail($channel, $request->get('thumbnail'), $request->input('name'), FALSE);
        $channel->genres()->sync($request->input('genres'));
        $channel->save();
        
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
