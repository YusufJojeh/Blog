@extends('layouts.dash-lay')

@section('title', 'My Feed')

@section('content')
    <div class="row gx-4 gy-4">
        @forelse ($Posts as $post)
            <div class="col-md-6 col-lg-4 my-4">
                <div class="card h-100 shadow-sm border-0 hover-shadow">
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}">
                    @endif

                    <div class="card-body d-flex flex-column">
                        {{-- Category Badge --}}
                        @if ($post->category)
                            <span class="badge bg-secondary mb-2">
                                {{ $post->category->name }}
                            </span>
                        @endif

                        {{-- Title --}}
                        <h5 class="card-title">{{ $post->title }}</h5>

                        {{-- Metadata --}}
                        <small class="text-muted mb-2">
                            By {{ optional($post->author)->name ?? '—' }}
                            &middot;
                            {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Unpublished' }}
                        </small>

                        {{-- Excerpt --}}
                        <p class="card-text flex-grow-1">
                            {{ Str::limit($post->content, 150) }}
                        </p>

                        {{-- Status Badge + Read More --}}
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span
                                class="badge
                                {{ $post->status === 'approved' ? 'bg-success' : ($post->status === 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                {{ ucfirst($post->status) }}
                            </span>

                            <a href="{{ route('reader.posts.show', $post) }}" class="btn btn-sm btn-primary">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">No posts found.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4 mx-2">
        {!! $Posts->onEachSide(1)->links() !!}
    </div>
@endsection

@push('styles')
    <style>
        /* Simple hover effect */
        .hover-shadow:hover {
            transform: translateY(-4px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            transition: all 0.2s ease-in-out;
        }

        .pagination {
            margin-left: 32px
        }
    </style>
@endpush
