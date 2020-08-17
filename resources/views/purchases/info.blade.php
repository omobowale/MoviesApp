@extends('layouts.app')


@section('content')

    <div>

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
        <div class="text-center"><a href="{{route('purchase')}}" class="btn btn-info">View all purchases</a></div>
    </div>

@endsection

