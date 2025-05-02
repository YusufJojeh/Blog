@extends('layouts.dash-lay')

@section('content')
    <h2>Spam Reports</h2>
    @include('partials.alerts')

    @forelse ($comments as $comment)
        <div class="card mb-3">
            <div class="card-body">
                <p><strong>Post:</strong> {{ $comment->post->title }}</p>
                <p><strong>By:</strong> {{ $comment->user->name }}</p>
                <p>{{ $comment->content }}</p>
                <small>{{ $comment->created_at->diffForHumans() }}</small>

                <form action="{{ route('author.comments.approve', $comment) }}" method="POST" class="mt-2">
                    @csrf
                    <button class="btn btn-success btn-sm">Approve & Clear Flag</button>
                </form>
            </div>
        </div>
    @empty
        <p>No spam reports.</p>
    @endforelse

    {{ $comments->links() }}
@endsection
