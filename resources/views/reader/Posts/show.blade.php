@extends('layouts.dash-lay')

@section('title', 'View Post')

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}">
                @endif

                <div class="card-body">
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

                    {{-- Back button --}}
                    <a href="{{ route('reader.feed') }}" class="btn btn-outline-primary">
                        ← Back to Feed
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
