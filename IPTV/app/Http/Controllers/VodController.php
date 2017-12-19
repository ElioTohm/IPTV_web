<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MovieRequest;
use App\Genre;
use App\StreamType;
use App\Stream;
use Intervention\Image\ImageManagerStatic as Image;
use App\Movie;
use Illuminate\Support\Facades\Storage;

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
        if ($request->exists('filter')) {
            $pagination = Movie::search($request->input('filter'))->paginate(env('ITEM_PER_PAGE'));
            $pagination->load('genres', 'stream.type');
            
        } else {
            $query = Movie::with('genres', 'stream.type');
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

    public function addMovie (MovieRequest $request)
    {
        $stream = new Stream();
        $stream->vid_stream = $request->input('stream');
        $stream->type = $request->input('stream_type.id');
        
        // create movie object
        $movie = new Movie();
        $movie->title = $request->input('title');
        $this->checkThumbnail($movie, $request->get('image'), TRUE);
        $movie->save();
        $genres = array();
        foreach ($request->input('genres') as $value) {
            array_push($genres, $value['id']);
        }
        $movie->genres()->sync($genres);
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
        $genres = array();
        foreach ($request->input('genres') as $value) {
            array_push($genres, $value['id']);
        }
        $this->checkThumbnail($movie, $request->get('image'), TRUE);
        $movie->genres()->sync($genres);
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

    private function checkThumbnail ($movie, $image, $addmovie) {
        if (substr( $image, 0, 10 ) === "data:image") {
            $imagename = $movie->title . '_'. $movie->id .'.png';
            $imagefileencoded = Image::make($image)->encode('png', 50);
            Storage::disk('public')->put('/movies/images/' . $imagename, $imagefileencoded);
            $movie->poster = $imagename;
        }
    }
}
