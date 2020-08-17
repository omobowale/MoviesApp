@extends('layouts.app')


@section('content')
    
    <div class="container-fluid">
        
        @if(count($purchases) > 0)
            <div><h4 class="text-center">MY MOVIES <span class="text-info ml-5">{{count($purchases)}}<span> item(s)</h4></div>
            @foreach($purchases as $purchase)
                @php
                $movie = App\Movie::find($purchase->movie_id);
                $string = explode(".", $movie->video);
                $ext = end($string);
                @endphp
                <div class="card mb-5">
                    <div class="card-header"><h5 class="card-title">{{$movie->title}}</h5></div>
                    <div class="card-body">
                        
                        <video style="width:60%; height:100%" controls>
                            <source src="/storage/uploads/videos/{{$movie->video}}" type="video/{{$ext}}"></source>
                    </video>
    
                    </div>
                    <div class="card-footer">
                        <h5></h5>
                        <p class="text-capitalize">Genre: <span class="lead">{{App\Movie::find($purchase->movie_id)->genre->genre}}</span></p>
                        <p>Purchased On: <span class="lead">{{$purchase->date_purchased}}</span></p>
                    </div>
                </div>
            @endforeach
            @else
                <div>
                    <p class="alert alert-success">You have not made any purchases yet</p>
                    <a class="btn btn-info" href="{{url('/')}}">Go to movies</a>
                </div>
            @endif


                

    </div>
@endsection