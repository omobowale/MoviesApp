@extends('layouts.app')



@section('content')
           


<div class="container-fluid mb-5">
        <div class="card">
            <div class="card-header text-white bg-dark">
                Monthly Sales
            </div>
            <div class="card-body">
                <form method="post" action="/report/filter" id="monthlysalesform" class="form-inline">
                    @csrf
                    <label for="from" class="form-label">From: </label>
                    <input class="form-control  @error('salesfrom') is-invalid @enderror" value="{{$from ?? ''}}" type="date" name="salesfrom" required />
                    @error('salesfrom')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <label for="to" class="form-label">To: &nbsp;</label>
                    <input class="form-control  @error('salesto') is-invalid @enderror" value="{{$to ?? ''}}" type="date" name="salesto" required />
                    @error('salesto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <button type="submit" class="btn btn-info">Search</button>
                </form>
            </div>
            <div class="card-footer">
                <table class="table">
                    <tr>
                        <th>Date</th>
                        <th>Quantity</th>
                    </tr>
                @if($purchases ?? 0)
                    @if(count($purchases) > 0)
                            @foreach($purchases['month'] as $key => $quantity)
                            <tr>
                                <td>{{$key}}</td>
                                <td> {{$quantity}}</td>
                            </tr>
                            @endforeach
                        
                    @else
                        <p class="alert alert-danger">No records found</p>    
                    @endif
                @endif
                </table>
            </div>
        </div>

        <a href="/report">Back to all reports</a>
</div>

@endsection