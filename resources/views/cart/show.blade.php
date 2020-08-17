@extends('layouts.app')


@section('content')

    <div class="container">

        @if(count($cart) > 0)
        <h4 class="">{{count($cart)}} Item(s) in your cart</h4>
        <hr>
        
            @foreach($cart as $key => $myc)
            <div class="row">
                <div class="col-xs-1 col-md-1 col-lg-1 pt-5">
                    {{$key + 1}}
                </div>
                <div class="col-xs-12 col-md-4 col-lg-4 row">
                    <div class="col-md-12"><img src="/storage/uploads/images/{{$myc->cover_image}}" style="width:10em; height:10em"></div>
                    <div class="col-md-12 pt-3 row">
                        <div class="col-md-12 h4">{{$myc->title}}</div>
                        <div class="col-md-12 text-capitalize">{{$myc->genre->genre}}</div>
                        <div class="col-md-12">{{$myc->date_released}}</div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-2 pt-5"><span class="lead">NGN</span>{{$myc->price}}</div>
                <div class="col-xs-12 col-md-3 col-lg-2 pt-5">
                    <div>
                        <a class="text-danger" style="text-decoration:none" href="/movies/cart-delete/{{$myc->id}}">
                            remove
                        </a>
                    </div>
                    <div>
                        <a class="text-info" style="text-decoration:none" href="/movies/cart-delete/{{$myc->id}}">
                            save for later
                        </a>
                    </div>
                </div>

            </div>
            <hr>
            @endforeach

        </div>

        <div class="container">
            <div class="card">
                <div class="card-header">
                    Purchase summary
                </div>
                <div class="card-body">
                    <h5>Subtotal: <span class="h6 ml-2">NGN{{$total}}</span></h5>
                    <h6>Tax: <span class="h6 ml-5">NGN {{'0'}}</span></h6>
                    <h4>Total: <span class="h6 ml-3" style="font-weight: bold">NGN{{$total}}</h4>
                </div>
                <div class="card-footer">
                    <img class="" src="https://www.paypalobjects.com/webstatic/mktg/logo-center/PP_Acceptance_Marks_for_LogoCenter_266x142.png"/>
                    <form method="POST" id="payment-form"  action="/payment/add-funds/paypal">
                        @csrf
                        <input type="hidden" name="amount" value="{{$total}}" />
                        <div><button class="btn btn-primary">Proceed to Check Out</button></div>
                    </form>
                    
                </div>
            </div>
            <div class="card-header text-center">
                <a href="/" class="btn btn-default border border-info">Continue shopping</a>
            </div>
        </div>


        @else
        <h3>You have no items in your cart</h3>
        <a class="btn btn-info" href="{{url('/')}}">Go to movies</a>

        @endif


    
   

        

    
@endsection