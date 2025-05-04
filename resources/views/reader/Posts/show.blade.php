@extends('layouts.dash-lay')

@section('title', 'View Post')

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">

                {{-- POST IMAGE --}}
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}">
                @endif

                <div class="card-body">

                    {{-- FLASH MESSAGES --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Category & Status --}}
                    <div class="d-flex justify-content-between mb-3">
                        @if ($post->category)
                            <span class="badge bg-secondary">
                                {{ $post->category->name }}
                            </span>
                        @endif

                        <span
                            class="badge
                            {{ $post->status === 'approved'
                                ? 'bg-success'
                                : ($post->status === 'rejected'
                                    ? 'bg-danger'
                                    : 'bg-warning text-dark') }}">
                            {{ ucfirst($post->status) }}
                        </span>
                    </div>

                    {{-- Title --}}
                    <h3 class="card-title mb-3">{{ $post->title }}</h3>

                    {{-- Metadata --}}
                    <p class="text-muted mb-4">
                        By {{ optional($post->author)->name ?? '—' }}
                        &middot;
                        {{ $post->published_at ? $post->published_at->format('M d, Y \a\t h:i A') : 'Unpublished' }}
                    </p>

                    {{-- Body --}}
                    <div class="card-text mb-4">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    {{-- Back to feed --}}
                    <a href="{{ route('reader.feed') }}" class="btn btn-outline-primary mb-5">
                        ← Back to Feed
                    </a>

                    {{-- Comments Section --}}
                    <section class="mb-5">
                        <div class="card bg-light">
                            <div class="card-body">

                                {{-- New Comment Form --}}
                                <form action="{{ route('reader.comments.store', $post) }}" method="POST" class="mb-4">
                                    @csrf

                                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="3"
                                        placeholder="Join the discussion and leave a comment!">{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <div class="mt-2 text-end">
                                        <button class="btn btn-primary" type="submit">
                                            Post Comment
                                        </button>
                                    </div>
                                </form>

                                {{-- Existing Comments --}}
                                @forelse($post->comments->where('approved', true) as $comment)
                                    <div class="d-flex mb-4">
                                        <div class="flex-shrink-0">
                                            <img class="rounded-circle"
                                                src="{{ optional($comment->reader)->avatar_url ?? 'https://dummyimage.com/50x50/ced4da/6c757d.jpg' }}"
                                                alt="{{ optional($comment->reader)->name }}">
                                        </div>
                                        <div class="ms-3 w-100">
                                            <div class="d-flex justify-content-between">
                                                <div class="fw-bold">
                                                    {{ optional($comment->reader)->name ?? 'Guest' }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ $comment->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            <p class="mb-0">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-muted">
                                        No comments yet. Be the first!
                                    </p>
                                @endforelse
                            </div>
                        </div>
                    </section>

                    {{-- Categories Widget --}}
                    <div class="card mb-4">
                        <div class="card-header">Categories</div>
                        <div class="card-body">
                            @if ($post->category)
                                <a href="{{ route('reader.feed', ['category' => $post->category->id]) }}"
                                    class="badge bg-dark text-decoration-none">
                                    {{ $post->category->name }}
                                </a>
                            @endif
                        </div>
                    </div>

                </div> {{-- .card-body --}}
            </div> {{-- .card --}}
        </div> {{-- .col-lg-8 --}}
    </div> {{-- .row --}}
@endsection
