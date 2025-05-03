@extends('layouts.dash-lay')
@section('title', 'Search Articles')
@section('content')
    <form class="form-inline mb-3">
        <input name="q" value="{{ $q }}" class="form-control mr-2" placeholder="Search…">
        <button class="btn btn-primary">Search</button>
    </form>
    @if ($articles->count())
        @foreach ($articles as $a)
            <div><a href="{{ route('reader.posts.show', $a) }}">{{ $a->title }}</a></div>
        @endforeach
        {{ $articles->links() }}
    @else
        <p>No results found.</p>
    @endif
@endsection
