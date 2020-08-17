<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;

class FilterController extends Controller
{
    
    public function showGroup(Request $request){
        if ($request->filled('genre')) {
            
            if($request->genre == "all"){
                $movies = Movie::all();
                return response()->json($movies);
            }

            else if($request->genre == "action"){
                $movies = Movie::where('genre', 'action')->get();                
                return response()->json($movies);
            }

            else if($request->genre == "adventure"){
                $movies = Movie::where('genre', 'adventure')->get();                
                return response()->json($movies);
            }
            else if($request->genre == "comedy"){
                $movies = Movie::where('genre', 'comedy')->get();                
                return response()->json($movies);
            }
            else if($request->genre == "drama"){
                $movies = Movie::where('genre', 'drama')->get();                
                return response()->json($movies);
            }
            else{
                return null;
            }

        }

        
        
    }
}
