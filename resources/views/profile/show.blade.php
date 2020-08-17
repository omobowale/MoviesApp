@extends('layouts.app')


@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            Your Profile
        </div>
        <div class="card-body">
            <h5 class="card-title">Username</h5>
            <p class="card-text">{{$user->name}}</p>
            <i title="edit" class="far fa-edit" data-target="#namemodal" data-toggle="modal"></i>
            <hr>
            <h5 class="card-title">Email</h5>
            <p class="card-text">{{$user->email}}</p>
            <i title="edit" class="far fa-edit" data-target="#emailmodal" data-toggle="modal"></i>
            <hr>
            <h5 class="card-title">Gender</h5>
            <p class="card-text">{{$user->gender}}</p>
            <i title="edit" class="far fa-edit" data-target="#gendermodal" data-toggle="modal"></i>
            <hr>
            <h5 class="card-title">Date Of Birth</h5>
            <p class="card-text">{{$user->date_of_birth}}</p>
            <i title="edit" class="far fa-edit" data-target="#date_of_birthmodal" data-toggle="modal"></i>
            <hr>
            @if(Auth::user()->role == 'admin')
            <h5 class="card-title">Role</h5>
            <p class="card-text">{{$user->role}}</p>
            @endif
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            Your Account
        </div>
        <div class="card-body">
            <h5 class="card-title">Password</h5>
            <p class="card-text">{{'hidden'}}</p>
            <i title="edit" class="far fa-edit" data-target="#passwordmodal" data-toggle="modal"></i>
            <hr>
        </div>
    </div>
</div>

    @include('profile.change', ['type' => 'text', 'tochange' => 'Name', 'paramname' => 'name', 'value' => $user->name])
    @include('profile.change', ['type' => 'email', 'tochange' => 'Email', 'paramname' => 'email', 'value' => $user->email])
    @include('profile.change', ['type' => 'date', 'tochange' => 'Date Of Birth', 'paramname' => 'date_of_birth', 'value' => $user->date_of_birth])


    <form action="/profile/{{ Auth::user()->id }}" method="post">
        @csrf
        @method('PUT')
        <div class="modal" id="passwordmodal">
            <div class="modal-content col-sm-10 col-lg-6 m-auto">
                <div class="modal-header">
                    <h2 class="modal-title m-auto">Change Password</h2>
                </div>
                <div class="modal-body">
                    <input required class="form-control mb-3" name="opassword"  type="password" placeholder="Enter Old Password" />
                    <input required class="form-control mb-3" name="npassword" type="password" placeholder="Enter New Password" />
                    <input required class="form-control mb-3" name="cpassword" type="password" placeholder="Confirm New Password" />
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default border border-danger" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-default border border-info">Update</button>
                </div>
            </div>
        </div>
    </form>

    <form action="/profile/{{ Auth::user()->id }}" method="post">
        @csrf
        @method('PUT')
        <div class="modal" id="gendermodal">
            <div class="modal-content col-sm-10 col-lg-6 m-auto">
                <div class="modal-header">
                    <h2 class="modal-title m-auto">Change Gender</h2>
                </div>
                <div class="modal-body">
                    
                    <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>

                            <div class="col-md-6">
                                <select id="gender" name="gender" class="form-control @error('gender') is-invalid @enderror">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-default border border-danger" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-default border border-info">Update</button>
                </div>
            </div>
        </div>
    </form>

@endsection