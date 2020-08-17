<form action="/profile/{{ Auth::user()->id }}" method="post">
        @csrf
        @method('PUT')
        <div class="modal" id="{{$paramname}}modal">
            <div class="modal-content col-sm-10 col-lg-6 m-auto">
                <div class="modal-header">
                    <h2 class="modal-title m-auto px-0">Change {{$tochange}}</h2>
                </div>
                <div class="modal-body">
                    <input required class="form-control" id="{{$paramname}}" name="{{$paramname}}" type="{{$type}}" value="{{$value}}" />
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default border border-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-default border border-info">Update</button>
                </div>
            </div>
        </div>
</form>