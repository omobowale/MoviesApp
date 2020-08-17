@extends('layouts.app')

@section('content')
    <div>
    @if ($message = Session::get('success'))
        <p class="alert alert-success">{!! $message !!}</p>
        <?php Session::forget('success');?>
    @endif
    @if ($message = Session::get('error'))
        <p class="alert alert-danger">{!! $message !!}</p>
        <?php Session::forget('error');?>
    @endif
    </div>
    <div class="container-fluid">
        <h3 class="bg-dark p-2 text-white">Latest Movies</h3>
        <div class="text-right fixed-bottom m-4">
            <form action="movies/create">
                <button class="btn btn-info" type="submit"> <i title="Add new movie" class="fas fa-plus-circle"></i> </button>
            </form>
        </div>

        <div class="row">
            <div class="col-xs-4 col-md-2 text-center">
                <div class="leftsidebar">
                    <p class="h5 font-weight-bold mt-4">Genre</p>
                    <ul class="list-unstyled pl-2 pb-3">
                        <li class="pb-2">
                            <a class="genrelink" href="{{url('/showgenre?genre=all')}}">All</a>
                        </li>
                        <li class="pb-2">
                            <a class="genrelink" href="{{url('/showgenre?genre=action')}}">Action</a>
                        </li>
                        <li class="pb-2">
                            <a class="genrelink" href="{{url('/showgenre?genre=adventure')}}">Adventure</a>
                        </li>
                        <li class="pb-2">
                            <a class="genrelink" href="{{url('/showgenre?genre=comedy')}}">Comedy</a>
                        </li>
                        <li class="pb-2">
                            <a class="genrelink" href="{{url('/showgenre?genre=drama')}}">Drama</a>
                        </li>
                    </ul>
                    <p class="h5 font-weight-bold mt-4">Category</p>
                    <ul class="list-unstyled pl-2 pb-3">
                        <li class="pb-2">
                            Regular
                        </li>
                        <li class="pb-2">
                            Featured
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-8 col-md-10">
                @if(count($movies->genre()->action) > 0)
                    <div class="row">
                    @forEach($movies as $movie)
                        <div class="col-xs-12 col-md-6 text-center">
                            <a href="/movies/{{$movie->id}}" style="text-decoration:none">
                                @include('movies.index', ['movie' => $movie])
                            </a>
                        </div>
                    @endforeach
                    </div>
                @endif
            </div>

        </div>

        

    <div class="container-fluid">
        <h3 class="bg-dark p-2 text-white">Featured Movies</h3>
    </div>

@endsection

<script>

window.addEventListener('load', function() {
    $(".genrelink").on('click', function(event){
        event.preventDefault();
        url = event.target.href;
        var i = 0;
        $.ajax({
            type: "get",
            url : url,
            success: function(data){

                

                data.map(function(movie, index){
                   
                });
                
            },
            error: function(){
                alert("error");
            }

        });
    });
})

</script> 
