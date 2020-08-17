<form action="/movies/{{$movie->id}}" method="post">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-white"><i title="delete" class="fas fa-trash text-danger"></i></button>
</form>