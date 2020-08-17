<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Movie;
use App\Genre;
use App\Purchase;
use Carbon\Carbon;
use Session;

class ReportController extends Controller
{
    function index(){

        $users = User::all();
        $movies = Movie::all();
        $purchases = Purchase::all();
        $usersages = array();
        
        return view('report.index')->with(['users' => $users, 'movies' => $movies, 'purchases' => $purchases]);

    }

    function filter(Request $request){

        
        if($request->has(['age', 'age_input'])){
           
            $request->validate([
                'age_input' => ['required', 'numeric'],
                'age' => ['required', 'string', 'min:2', 'max:2']
            ]);
           
            if($request->age == 'lt'){
                $age = '<';
            }
            else if($request->age == 'gt'){
                $age = '>';
            }
            else if($request->age == 'eq'){
                $age = '=';
            }
            else {
                $age = "unknown";
            }

            if($age != "unknown"){
                $users = User::where('age', $age, $request->age_input)->get();
                return $users;
            }
        }

        else if($request->has(['filtertype', 'genre_id']) && $request->filled('genre_id')){

            $request->validate([
                'genre_id' => ['required', 'numeric']
            ]);
            
            if($request->genre_id == 0){
                $movies = Movie::all();
            }
            else{
                $movies = Movie::where('genre_id', $request->genre_id)->get();
            }

            $genres = array();

            //For each movie genre_id, get the corresponding genre
            foreach($movies as $movie){
                array_push($genres, Genre::find($movie->genre_id)->genre);
            }
            return response()->json(array('movies' => $movies, 'genres' => $genres));
        }



        else if($request->has(['filtertype', 'endvalue']) && $request->filled('endvalue')){
            $request->validate([
                'endvalue' => ['required', 'min:1', 'string']
            ]);
            
           
            $movies = Movie::query()->where('title', 'LIKE', "%$request->endvalue")->get();

            $genres = array();

            //For each movie genre_id, get the corresponding genre
            foreach($movies as $movie){
                array_push($genres, Genre::find($movie->genre_id)->genre);
            }

            return response()->json(array('movies' => $movies, 'genres' => $genres));
        }


        

    }



    public function filter2(Request $request){

        if($request->has(['salesfrom', 'salesto']) && $request->filled(['salesfrom', 'salesto'])){
            $earliestdate = date('d-m-Y', mktime(0,0,0,1,0));
            
            $request->validate([
                'salesfrom' => ['required', 'date', 'before:tomorrow', "after:$earliestdate"],
                'salesto' => ['required', 'date', 'after_or_equal:salesfrom', 'before_or_equal:tomorrow']
            ]);
            
            $from = $request->salesfrom;
            $newfrom = explode('-', $from)[1];
            //dd($newfrom);
            
            $to = $request->salesto;
            $newto= explode('-', $to)[1];
            //dd($newto);

            $purchases = Purchase::groupBy('movie_id')->get(['movie_id']);
            
            $monthsarray = array();
            for($i = $newfrom; $i <= $newto; $i++){
                array_push($monthsarray, $i);
            }

            $reportarray = array();
            $monthsnamesarray = array();
            
            foreach($monthsarray as $month){  
                $monthname = date('M yy', mktime(0, 0, 0, $month));
                $reportarray['month'][$monthname] = Purchase::whereMonth('date_purchased', $month)->get()->count();
            }


            return view('report.monthlysales')->with(['purchases' => $reportarray, 'from' => $from, 'to' => $to ]);
        }

    }

    public function monthlysales(Request $request){    
            
            $from = date('Y-m-d', mktime(0,0,0,1,1));
            $to = date('Y-m-d');

            $purchases = Purchase::groupBy('movie_id')->get(['movie_id']);

            $monthsarray = array();
            for($i=1; $i<=date('m'); $i++){
                array_push($monthsarray, $i);
            }

            $reportarray = array();
            $monthsnamesarray = array();
            
            foreach($monthsarray as $month){  
                $monthname = date('M yy', mktime(0, 0, 0, $month));
                $reportarray['month'][$monthname] = Purchase::whereMonth('date_purchased', $month)->get()->count();
            }


            return view('report.monthlysales')->with(['purchases' => $reportarray, 'from' => $from, 'to' => $to]);

    }
}
