<div class="card" style="">
        <img class="card-img-top" style="height:20rem" src="/storage/uploads/images/{{$movie->cover_image}}" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title"><span>Title : </span>{{$movie->title}}</h5>
            <p class="card-text"><span>Synopsis : </span>{{$movie->synopsis}}</p>
            <p class="card-text"><span>Duration : </span><small class="text-muted">{{$movie->duration}}</small></p>
            <p class="card-text"><span>Price : </span><small class="text-muted">NGN{{$movie->price}}</small></p>
            @if(!Auth::guest())
                @if(!$purchased)
                    @include('cart.index', ["movie", $movie])
                @else
                    <span class="text-success">Already Bought By You</span>
                @endif
            @endif
            <hr>
            @if(!Auth::guest() && Auth::user()->role == 'admin')
            <div class="">
                <div class="text-info">
                    <a href="/movies/{{$movie->id}}/edit"><i title="edit" class="far fa-edit"></i></a>
                </div>
                <span class="text-danger">
                    @include('movies.delete', ["movie", $movie])
                </span>
            </div>
            @endif

        </div>
        
  </div>