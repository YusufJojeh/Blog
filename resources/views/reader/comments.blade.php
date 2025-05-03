@extends('layouts.dash-lay')
@section('title', 'My Comments')
@section('content')
    @foreach ($comments as $c)
        <div class="card mb-2">
            <div class="card-body">
                <small class="text-muted">{{ $c->created_at }}</small>
                <p>{{ $c->body }}</p>
                <a href="{{ route('reader.posts.show', $c->post) }}">View Post</a>
            </div>
        </div>
    @endforeach
    {{ $comments->links() }}
@endsection
