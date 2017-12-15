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
    public function getChannels (Request $request) 
    {
        $query = Channel::with('genres');

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

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('name', 'like', $value);
            });
        }

        $pagination = $query->with('stream.type')->paginate(env('ITEM_PER_PAGE'));
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
        // create stream object
        $stream = new Stream();
        $stream->vid_stream = $request->input('stream');
        $stream->type = $request->input('stream_type.id');
        
        // create channel object
        $channel = new Channel();
        $channel->number = $request->input('number');
        $channel->name = $request->input('name');
        $this->checkThumbnail($channel, $request->get('thumbnail'), $request->input('name'), TRUE);
        $channel->save();
        $genres = array();
        foreach ($request->input('genres') as $value) {
            array_push($genres, $value['id']);
        }
        $channel->genres()->sync($genres);
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
        $stream->type = $request->input('stream_type.id');
        $stream->save();
        // update channel table
        $channel->number = $request->input('number');
        $channel->name = $request->input('name');
        // $this->checkThumbnail($channel, $request->get('thumbnail'), $request->input('name'), FALSE);
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

    private function checkThumbnail ($channel, $image, $name, $addchannel) {
        if (substr( $image, 0, 10 ) === "data:image") {
            Image::make($image)->encode('png', 50)->save(public_path('images/device/channels') . $name . '.png');
            $channel->thumbnail = $name . '.png';
        }
    }
}
