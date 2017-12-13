<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MovieRequest;
use App\Genre;
use App\StreamType;
use App\Stream;
use Intervention\Image\ImageManagerStatic as Image;
use App\Movie;


class VodController extends Controller
{
    // index
    public function index () 
    {
    	return view('vod');
    }

    // get Movies  
    public function getMovies (Request $request) 
    {
        $query = Movie::with('genres');

        // handle sort option
        if ($request->has('sort')) {
            // handle multisort
            $sorts = explode(',', $request->sort);
            foreach ($sorts as $sort) {
                list($sortCol, $sortDir) = explode('|', $sort);
                $query = $query->orderBy($sortCol, $sortDir);
            }
        } else {
            $query = $query->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('title', 'like', $value);
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

    public function addMovie (MovieRequest $request)
    {
        $stream = new Stream();
        $stream->vid_stream = $request->input('stream');
        $stream->type = $request->input('stream_type.id');
        
        // create movie object
        $movie = new Movie();
        $movie->poster = $request->input('poster');
        $movie->title = $request->input('title');
        // $this->checkThumbnail($movie, $request->get('thumbnail'), $request->input('name'), TRUE);
        $movie->save();
        $movie->genres()->sync($request->input('genres'));
        $stream->movie = $movie->id;
        $stream->save();
        return $movie;
    }
    
    public function deleteMovie ($id) 
    {
        $movie = Movie::find($id);
        $movie->delete();
    }

    public function updateMovie($id, MovieRequest $request) 
    {
        // create stream object
        $movie = Movie::find($id);
        //update stream table
        $stream = $movie->stream()->first();
        $stream->vid_stream = $request->input('stream');
        $stream->type = $request->input('stream_type.id');
        $stream->save();
        // update movie table
        $movie->title = $request->input('title');
        $movie->poster = $request->input('poster');
        // $this->checkThumbnail($movie, $request->get('thumbnail'), $request->input('name'), FALSE);
        $movie->genres()->sync($request->input('genres'));
        $movie->save();
    }

    public function getGenresNStreamTypes () 
    {
        $genres = Genre::get(['id', 'name']);

        $stream_types = StreamType::get(['id','name']);
        
        return response()->json([
            'genres' => $genres,
            'stream_types' => $stream_types,
        ]);
    }
}
