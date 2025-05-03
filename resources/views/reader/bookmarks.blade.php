@extends('layouts.dash-lay')
@section('title', 'Bookmarks')
@section('content')
    @foreach ($posts as $a)
        <div class="d-flex justify-content-between mb-2">
            <div><a href="{{ route('reader.posts.show', $a->post) }}">{{ $a->post->title }}</a></div>
            <form method="POST" action="{{ route('reader.bookmarks.destroy', $a->post) }}">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm">Remove</button>
            </form>
        </div>
    @endforeach
    {{ $posts->links() }}
@endsection
