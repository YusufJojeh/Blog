@extends('layouts.app')
@section('title')index @endsection
@section('content')
<div class="text-center">
    <a href="{{ route("posts.create") }}" class="btn btn-success mt-5">Create Post</a>
</div>

        <table class='table table-bordered table-light mt-5 text-center'>
    <thead>
        <tr>
            <th scope='col'>#ID</th>
            <th scope='col'>Title</th>
            <th scope='col'>Posted By</th>
            <th scope='col'>Created At</th>
            <th scope='col'>Actions</th>


        </tr>
    </thead>

        <tbody>

    @foreach ($posts as $post)
<tr>
    <td>{{ $post->id}}</td>
    <td>{{ $post->title }}</td>
    <td>{{ $post->user ? $post->user->name :'No Creator'}}</td>
    <td>{{ $post->created_at }}</td>
    <td>
        <a href="{{ route('posts.show' ,$post->id )}}"class='btn btn-info text-white'>View</a>
        <a href="{{ route('posts.edit',$post->id) }}" class='btn btn-primary'>Edit</a>
        <form style="display: inline;" method="POST" action="{{route('posts.destroy', $post->id)}}">
                        @csrf
                        @method('DELETE')

<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Delete
</button>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Deleting</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this post ?
      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
        </form>
    </td>
</tr>
    @endforeach

</tbody>
</table>
</div>
@endsection


