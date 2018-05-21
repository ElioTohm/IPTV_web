<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\CatchUp;
use App\Jobs\StreamPassThrough;
use App\Channel;
use App\Genre;
use App\StreamType;
use App\Stream;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Requests\ChannelRequest;
use Illuminate\Support\Facades\Storage;

class ChannelController extends Controller
{
    /**
     * return all channels
     */
    public function getChannels (Request $request) 
    {
        if ($request->exists('filter')) {
            $pagination = Channel::search($request->input('filter'))->paginate(env('ITEM_PER_PAGE'));
            $pagination->load('genres', 'stream.type');
            
        } else {
            $query = Channel::with('genres', 'stream.type');
            // handle sort option
            if ($request->has('sort')) {
                // handle multisort
                $sorts = explode(',', $request->sort);
                foreach ($sorts as $sort) {
                    list($sortCol, $sortDir) = explode('|', $sort);
                    $query = $query->orderBy($sortCol, $sortDir);
                }
            } else {
                $query = $query->orderBy('number', 'asc');
            }
            $pagination = $query->paginate(env('ITEM_PER_PAGE'));
            // transform image and 
            $pagination->getCollection()->transform(function ($channel) {
                    $url = explode('/',$channel->thumbnail);
                    $channel->thumbnail = Storage::disk('public')->url('channels/images/' . $url[sizeof($url) - 1]);
                    return $channel;
                });
        }

        $pagination->appends([
            'sort' => $request->sort,
            'filter' => $request->filter,
            'per_page' => $request->per_page
        ]);

        return response()->json(
                $pagination
        );
    }

    public function addChannel (ChannelRequest $request) 
    {        
        if (Channel::all()->count() == env('CHANNEL_LIMIT')) {
            // create channel object
            $channel = new Channel();
            $channel->number = $request->input('number');
            $channel->name = $request->input('name');
            $channel->price = $request->input('price');
            $channel->thumbnail = $request->input('thumbnail');
            $channel->save();

            $genres = array();
            foreach ($request->input('genres') as $value) {
                array_push($genres, $value['id']);
            }
            $channel->genres()->sync($genres);

            // create stream object
            $stream = new Stream();
            $stream->vid_stream = $request->input('stream');
            $stream->type = $request->input('stream_type.id');
            $stream->channel = $channel->number;
            $stream->save();

            return $channel;
        }
    }

    public function updateChannel ($id, ChannelRequest $request) 
    {
        $channel = Channel::find($id);

        //update stream table
        $stream = $channel->stream()->first();
        $stream->vid_stream = $request->input('stream');
        $stream->type = $request->input('stream_type.id');
        $stream->save();
        // update channel table
        $channel->number = $request->input('number');
        $channel->name = $request->input('name');
        $channel->price = $request->input('price');
        $channel->thumbnail = $request->input('thumbnail');
        $genres = array();
        foreach ($request->input('genres') as $value) {
            array_push($genres, $value['id']);
        }
        $channel->genres()->sync($genres);
        $channel->save();
        
    }

    public function deleteChannel ($id) 
    {
        $channel = Channel::find($id);
        $channel->delete();
    }

    // Convert UDP to hls and save up to 24h 
    public function catchup ($channel_id) 
    {
        $channel = Channel::with('stream')->find($channel_id);
        dispatch(new CatchUp($channel));
        return 200;   
    }

    // convert UDP to hls save nothing 
    public function channelPathThrough($channel_id) 
    {
        $channel = Channel::with('stream')->find($channel_id);
        dispatch(new StreamPassThrough($channel));
        return 200; 
    }
}
