@extends('layouts.app')

@section('content')

<div class="container-fluid">
    
        @if ($message = Session::get('success'))
            <p class="alert alert-success">{!! $message !!}</p>
            <?php Session::forget('success');?>
        @endif
        @if ($message = Session::get('error'))
            <p class="alert alert-danger">{!! $message !!}</p>
            <?php Session::forget('error');?>
        @endif
    
        @if(count($genre->movies) > 0)
            <div class="card-header text-uppercase mx-3 bg-dark text-white">{{$genre->genre}}</div>
            <div class="row m-auto">
            @foreach ($genre->movies as $movie)
                <div class="col-xs-12 col-sm-6 col-md-4 text-center">
                    <a href="/movies/{{$movie->id}}" style="text-decoration:none">
                    @if(!Auth::guest())
                        @if(count(App\Purchase::where(['user_id'=> Auth::user()->id, 'movie_id' => $movie->id])->get()) > 0)
                            @php 
                                $purchased = true;
                            @endphp
                        @else
                            @php 
                                $purchased = false;
                            @endphp
                        @endif
                    @else
                        @php 
                            $purchased = true;
                        @endphp
                    @endif
                        @include('movies.index', ['movie' => $movie, 'purhased'=>$purchased])
                    
                    </a>
                </div>
            @endforeach
            </div>
        @endif

        @if(Auth::user()->role == 'admin')
    <div class="text-right fixed-bottom m-4">
        <form action="movies/create">
            <button class="btn btn-info" type="submit"> <i title="Add new movie" class="fas fa-plus-circle"></i> </button>
        </form>
    </div>
    @endif

</div>
@endsection