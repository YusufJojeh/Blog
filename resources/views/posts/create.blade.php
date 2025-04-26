@extends('layouts.app')
@section('title')Create @endsection
@section('content')
<form method="POST" action="{{route('posts.store')}}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input name="title" type="text" class="form-control" value="{{old('title')}}">
        </div>
        <div class="mb-3">
            <label  class="form-label">Description</label>
            <textarea name="description" class="form-control"  rows="3">{{old('description')}}</textarea>
        </div>

        <div class="mb-3">
            <label  class="form-label">Post Creator</label>
            <select name="post_creator" class="form-control">
                @foreach (  $users as $user )
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach


            </select>
            <div class="mt-3">
            <label for="image">Choose Image:</label>
            <input type="file" name="image" id="image" accept="image/*" required>
            </div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
@endsection
