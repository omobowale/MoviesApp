<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use Illuminate\Support\Facades\Storage;

class MoviesController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('role:admin')->except(['index', 'show']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::all();
        return view('welcome')->with("movies", $movies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('movies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['string', 'min:2', 'required'],
            'synopsis' => ['string', 'min:8', 'required'],
            'genre_id' => ['numeric', 'required'],
            'actors' => ['required'],
            'directors' => ['required'],
            'date_released' => ['required', 'date', 'before:tomorrow'],
            'price' => ['required', 'numeric']
        ]);

        //Get image and upload
        if($request->hasFile('cover_image')){
                $request->validate([
                    'cover_image' => 'image|mimes:png,jpeg,jpg'
                ]);

                
                $imageextension = $request->cover_image->extension();

                $imagename = basename($request->file('cover_image')) . time();

                $request->cover_image->storeAs('/public/uploads/images', $imagename . "." . $imageextension);                

                $imageurl = $imagename . "." . $imageextension;


        }

       

        if($request->hasFile('video')){
            if($request->file('video')->isValid()){
                $validated = $request->validate([
                    'video' => 'mimes:mp4,3gp|max:5000000', 
                ]);

                $videoextension = $request->video->extension();

                $videoname = basename($request->file('video')) . time();

                $request->video->storeAs('/public/uploads/videos', $videoname . "." . $videoextension);
                

                $videourl = $videoname . "." . $videoextension;
                $movie = Movie::create([
                    'title' => $request->title,
                    'genre_id' => $request->genre_id,
                    'synopsis' => $request->synopsis,
                    'actors' => $request->actors,
                    'directors' => $request->directors,
                    'duration' => 100,
                    'date_released' => $request->date_released,
                    'price' => $request->price,
                    'video' => $videourl,
                    'cover_image' => $imageurl
                ]);

               
                return redirect('/');
            }

            

        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::find($id);
        return view('movies.show')->with("movie", $movie);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $movie = Movie::find($id);
        return view('movies.edit')->with("movie", $movie);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $movie = Movie::find($id);
        $validated = false;
       $validated = $request->validate([
            'title' => ['string', 'min:2', 'required'],
            'synopsis' => ['string', 'min:8', 'required'],
            'genre_id' => ['numeric', 'required'],
            'actors' => ['required'],
            'directors' => ['required'],
            'date_released' => ['required', 'date', 'before:tomorrow'],
            'price' => ['required', 'numeric']
        ]);

        //Get image and upload
        //if an image is selected
        if($request->hasFile('cover_image')){
                $validated = $request->validate([
                    'cover_image' => 'image|mimes:png,jpeg,jpg'
                ]);

                
                $imageextension = $request->cover_image->extension();

                $imagename = basename($request->file('cover_image')) . time();

                $request->cover_image->storeAs('/public/uploads/images', $imagename . "." . $imageextension);                

                $imageurl = $imagename . "." . $imageextension;


        }

        //if no image is selected, use the one from the database
        else{
            $imageurl = $movie->cover_image;
        }

       
        //Get video and upload
        //if a video is selected
        if($request->hasFile('video')){
            if($request->file('video')->isValid()){
                $validated = $request->validate([
                    'video' => 'mimes:mp4,3gp|max:5000000', 
                ]);

                $videoextension = $request->video->extension();

                $videoname = basename($request->file('video')) . time();

                $request->video->storeAs('/public/uploads/videos', $videoname . "." . $videoextension);
                

                $videourl = $videoname . "." . $videoextension;
                

               
                
            }

            

        }

        //if no image is selected, use the one from the database
        else{
            $videourl = $movie->video;
        }

        if($validated){
            $movie->title = $request->title;
            $movie->genre_id = $request->genre_id;
            $movie->synopsis = $request->synopsis;
            $movie->actors = $request->actors;
            $movie->directors = $request->directors;
            $movie->date_released = $request->date_released;
            $movie->price = $request->price;
            $movie->cover_image = $imageurl;
            $movie->video = $videourl;
            $movie->save();
            return redirect('/');
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $movie = Movie::find($id);
       $movie->delete();
       return redirect('/genres');
    }
}
