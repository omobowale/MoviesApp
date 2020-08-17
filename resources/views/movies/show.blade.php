@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img class="card-img-top" style="" src="/storage/uploads/images/{{$movie->cover_image}}" alt="Card image cap">
            </div>
            <div class="col-md-6 text-center pt-5">
                <h5 class="card-title"><span>Title : </span>{{$movie->title}}</h5>
                <p class="card-text"><span>Synopsis : </span>{{$movie->synopsis}}</p>
                <p class="card-text text-capitalize"><span>Genre : </span>{{$movie->genre->genre}}</p>
                <p class="card-text"><span>Actors : </span>{{$movie->actors}}</p>
                <p class="card-text"><span>Director(s) : </span>{{$movie->directors}}</p>
                <p class="card-text"><span>Date released : </span>{{$movie->date_released}}</p>
                <p class="card-text"><span>Price : NGN</span>{{$movie->price}}</p>
                <p class="card-text"><span>Duration : </span><small class="text-muted">{{$movie->duration}} mins</small></p>
                @if(!Auth::guest())
                    @if(!count($purchase = App\Purchase::where(['user_id'=> Auth::user()->id, 'movie_id' => $movie->id])->get()) > 0)
                        <div>@include('cart.index', ["movie", $movie])</div>
                    @else
                        <p class="text-success">Already Bought by You</p>
                        <p class="text-danger">Date Bought: {{$purchase[0]->date_purchased}}</p>
                    @endif
                    <hr>
                    <div class="">
                    @if(Auth::user()->role == 'admin')
                    <div class="text-info">
                        <a href="/movies/{{$movie->id}}/edit"><i title="edit" class="far fa-edit"></i></a>
                    </div>
                    <span class="text-danger">
                        @include('movies.delete', ["movie", $movie])
                    </span>
                    @endif
                @endif
                
            </div>
            </div>
            
    </div>
        
    </div>

@endsection