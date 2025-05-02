@extends('layouts.dash-lay')

@section('content')
    <h2>Comments on My Posts</h2>
    @include('partials.alerts')

    @forelse ($comments as $comment)
        <div class="card mb-3">
            <div class="card-body">
                <p><strong>Post:</strong> {{ $comment->post->title }}</p>
                <p><strong>By:</strong> {{ $comment->user->name }}</p>
                <p>{{ $comment->content }}</p>
                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>

                @unless ($comment->approved)
                    <form action="{{ route('author.comments.approve', $comment) }}" method="POST" class="mt-2">
                        @csrf
                        <button class="btn btn-success btn-sm">Approve</button>
                    </form>
                @endunless
            </div>
        </div>
    @empty
        <p>No comments yet.</p>
    @endforelse

    {{ $comments->links() }}
@endsection
