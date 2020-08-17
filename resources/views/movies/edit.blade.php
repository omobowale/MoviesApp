@extends ('layouts.app')

@section('content')
<div class="offset-3 col-6 mb-5">
<h3>Edit Movie</h3>
    <form action="/movies/{{$movie->id}}" method="post" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <div class="form-group">
            <label for="title">Title</label>
            <input value="{{ $movie->title }}" class="form-control @error('title') is-invalid @enderror" id="title" name="title" type="text" placeholder="Enter Movie Title" required/>
            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="cover_image">Cover Image</label>
            <input value="{{ $movie->cover_image }}" class="form-control @error('cover_image') is-invalid @enderror" type="file" id="cover_image" name="cover_image" placeholder="Insert Cover Image" />
            @error('cover_image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


        <div class="form-group">
            <label for="synopsis">Synopsis</label>
            <textarea  class="form-control @error('synopsis') is-invalid @enderror" id="synopsis" rows="7" name="synopsis"  placeholder="Enter Movie Synopsis" required>{{ $movie->synopsis }}</textarea>
            @error('synopsis')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="genre_id">Genre</label>
            <select class="form-control @error('genre_id') is-invalid @enderror" id="genre_id" name="genre_id">
                <option value="1">Action</option>
                <option value="2">Adventure</option>
                <option value="3">Family Drama</option>
                <option value="4">Comedy</option>
            </select>
            @error('genre_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="actors">Main Actors</label>
            <input value="{{ $movie->actors }}" type="text" name="actors" id="actors" placeholder="Enter Names of Actors separated by comma" class="form-control @error('actors') is-invalid @enderror"/>
            @error('actors')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="directors">Director(s)</label>
            <input value="{{ $movie->directors }}" type="text" name="directors" id="directors" placeholder="Enter Names of Director(s) separated by comma" class="form-control @error('directors') is-invalid @enderror"/>
            @error('directors')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="video">Video</label>
            <input value="{{ $movie->video }}" class="form-control @error('video') is-invalid @enderror" id="video" name="video" type="file" />
            @error('video')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_released">Date Released</label>
            <input value="{{ $movie->date_released }}" name="date_released" id="date_released" type="date" class="form-control @error('date_released') is-invalid @enderror"/>
            @error('date_released')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">Price (NGN)</label>
            <input value="{{ $movie->price }}" id="price" name="price" type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" placeholder="Please Enter Price"/>
            @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button class="btn btn-block btn-info">Update Movie</button>
    </form>
</div>

@endsection










