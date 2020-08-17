@extends('layouts.app')



@section('content')
           

<div class="container-fluid mb-5">
        <div class="card">
            <div class="card-header text-white bg-dark">
                Total Number of films purchased
            </div>
            <div class="card-body">
                {{count($purchases)}}
            </div>
        </div>
</div>

<div class="container-fluid mb-5">
        <div class="card">
            <div class="card-header text-white bg-dark">
                Monthly Sales
            </div>
            <div class="card-body">
                <a href="{{url('report/monthlysales')}}">Click here to view</a>

            </div>
        </div>
</div>

<div class="container-fluid">
        <!--Users Section-->
        <div class="card mt-4">
            <div class="card-header bg-dark text-white">All Users : <span class="ml-3" id="countusers">{{count($users)}}</span> user(s) found</div> 
            <div class="card-body">
                    <form action="" id="agefilterform" class="form-inline">
                        <label class="form-label">Filter By: &nbsp;</label>
                        <select name="age" class="form-control mr-2" style="">
                            <option value="gt">Age > </option>
                            <option value="eq">Age = </option>
                            <option value="lt">Age < </option>
                        </select>
                        <input name="age_input" type="number" class="form-control mr-2" placeholder="value" required />
                        <button type="submit" class="btn btn-info">Search</button>
                    </form>
            </div>
        
        
            <div class="card-footer">    
                <table id="userstable" class="table table-responsive">
                    <tr>
                        <th class="" style="width:10%">User ID</th>
                        <th style="width:18%;">Name</th>
                        <th style="width:18%;">Email</th>
                        <th style="width:18%;">Phone Number</th>
                        <th style="width:18%;">Age</th>
                        <th style="width:18%;">Date Of Birth</th>
                    </tr>
                    @if(count($users) > 0)
                        @foreach($users as $key => $user)
                            <tr class="all">
                                <td style="width:10%">{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->phone_number}}</td>
                                <td>{{$user->age}}</td>
                                <td>{{$user->date_of_birth}}</td>
                            </tr>
                        @endforeach
                    @endif
                    
                </table>
                <div class="usersmessage text-center"></div>
            </div>
        </div>
</div>

<div class="container-fluid">
        <div class="card mt-4">
            <div class="card-header bg-dark text-white">All Movies : <span class="ml-3" id="countmovies">{{count($movies)}}</span> movie(s) found</div> 
            <div class="card-body">
                <form id="genrefilterform" class="form-inline" action="">
                    <label class="form-label">Filter By: &nbsp;</label>
                    <select name="filtertype" id="filtertype" class="form-control mr-2">
                        <option value="genre">Genre </option>
                        <option value="endswith">Product Ends With</option>
                    </select>
                    <select name="genre_id" id="genre_id" class="form-control mr-2">
                        <option value="0">All</option>
                        <option value="1">Action</option>
                        <option value="2">Adventure</option>
                        <option value="3">Family Drama</option>
                        <option value="4">Comedy</option>
                    </select>
                    <input name="endvalue" placeholder="Enter end value" id="endvalue" class="form-control mr-2" style="display:none" />

                    <button class="btn btn-info">Search</button>
                </form>
            </div>
            
            <div class="card-footer">
                <table id="moviestable" class="table table-responsive">
                    <tr class="">
                        <th class="" style="width:10%">Movie ID</th>
                        <th style="width:18%;">Title</th>
                        <th style="width:18%;">Synopsis</th>
                        <th style="width:18%;">Genre</th>
                        <th style="width:18%;">Actors</th>
                        <th style="width:18%;">Price (NGN)</th>
                    </tr>
                    @if(count($movies) > 0)
                        @foreach($movies as $key => $movie)
                            <tr class="all">
                                <td class="" style="width:10%">{{$movie->id}}</td>
                                <td class="text-capitalize">{{$movie->title}}</td>
                                <td>{{$movie->synopsis}}</td>
                                <td class="text-capitalize">{{$movie->genre->genre}}</td>
                                <td>{{$movie->actors}}</td>
                                <td>{{$movie->price}}</td>
                            </tr>
                        @endforeach
                    @endif
                    
                </table>
                <div class="moviesmessage text-center"></div>
            </div>
        </div>

</div>




@endsection



<script>

window.addEventListener('load', function() {
    $("#filtertype").change(function(event){
        if($(this).val() == "endswith"){
            $("#genre_id").val('')
            $("#genre_id").hide();
            $("#endvalue").show();
        }else{
            $("#genre_id").show();
            $("#endvalue").val('');
            $("#endvalue").hide();
        }
    });

    $("#agefilterform").submit(function(event){
        event.preventDefault();
        var datatopost = $(this).serialize();

        $.ajax({
            type: "get",
            url : "/report/filter",
            data : datatopost,
            success: function(data){
                $("#userstable").find(".all").remove();
                console.log(data);
                if(data.length < 1){
                    $(".usersmessage").html(`<p class="alert alert-danger w-100">No records found</p>`);
                }
                else{
                    console.log(data.length);
                    var count = data.length;
                    $(".usersmessage").find(".alert").remove();
                    for(i=0; i<data.length; i++){
                        var user = data[i];
                        $("#userstable").append(`
                        <tr class="all">
                            <td class="" style="width:10%">${user.id}</td>
                            <td class="text-capitalize">${user.name}</td>
                            <td>${user.email}</td>
                            <td class="text-capitalize">${user.phone_number}</td>
                            <td>${user.age}</td>
                            <td>${user.date_of_birth}</td>
                        </tr>
                        
                        `);
                    }
                    document.getElementById("countusers").innerText = count;
                }
                
            },
            error: function(){
                alert("error in fetching users");
            }

        });
    });

    $("#genrefilterform").submit(function(event){
        event.preventDefault();
        var datatopost = $(this).serialize();

        $.ajax({
            type: "get",
            url : "/report/filter",
            data : datatopost,
            success: function(data){
                $("#moviestable").find(".all").remove();
                console.log(data);
                if(data.movies.length < 1){
                    $(".moviesmessage").html(`<p class="alert alert-danger w-100">No records found</p>`);
                }
                else{
                    var count = 0;
                    $(".moviesmessage").find(".alert").remove();
                    data.movies.map(function(movie, index){
                        $("#moviestable").append(`
                        <tr class="all">
                            <td class="" style="width:10%">${movie.id}</td>
                            <td class="text-capitalize">${movie.title}</td>
                            <td>${movie.synopsis}</td>
                            <td class="text-capitalize">${data.genres[index]}</td>
                            <td>${movie.actors}</td>
                            <td>${movie.price}</td>
                        </tr>
                        
                        `);
                        count = index + 1;
                    });
                    document.getElementById("countmovies").innerText = count;
                }
            },
            error: function(){
                alert("error in fetching movies");
            }

        });
    });



   

    
})

</script> 