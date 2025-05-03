{{-- resources/views/author/posts/index.blade.php --}}
@extends('layouts.dash-lay')

@section('title', 'All Posts')

@section('content')
    @php
        use Illuminate\Support\Str;
    @endphp

    <section class="content">
        <div class="container-fluid">

            {{-- Header --}}
            <div class="row mb-3">
                <div class="col-sm-6">
                    <h1 class="text-white">MY Posts</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('author.posts.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Create Post
                    </a>
                </div>
            </div>

            {{-- Alerts --}}
            @include('partials.alerts')

            {{-- Cards Grid --}}
            <div class="row">
                @forelse($posts as $post)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            {{-- Image --}}
                            @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top"
                                    alt="Image for {{ $post->title }}">
                            @endif

                            <div class="card-body">
                                {{-- ID & Title --}}
                                <h5 class="card-title">
                                    #{{ $post->id }}. {{ Str::limit($post->title, 50) }}
                                </h5>

                                {{-- Excerpt --}}
                                <p class="card-text">{{ Str::limit(strip_tags($post->content), 100) }}</p>

                                {{-- Details List --}}
                                <ul class="list-unstyled mb-3">



                                    <li><strong>Author :</strong> {{ Auth::user()->name ?? '—' }}</li>
                                    <li><strong>Status:</strong> {{ ucfirst($post->status) }}</li>

                                    <li><strong>Published At:</strong>
                                        {{ optional($post->published_at)->format('Y-m-d') ?? '—' }}</li>
                                    <li><strong>Created At:</strong> {{ $post->created_at->format('Y-m-d') }}</li>

                                </ul>

                                {{-- Actions --}}
                                <div class="btn-group" role="group">
                                    <a href="{{ route('author.posts.edit', $post) }}" class="btn btn-sm btn-primary mx-2"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#deleteModal-{{ $post->id }}" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Delete Confirmation Modal --}}
                    <div class="modal fade" id="deleteModal-{{ $post->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalLabel-{{ $post->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel-{{ $post->id }}">
                                        Confirm Delete
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete “{{ Str::limit($post->title, 20) }}”?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                                        Cancel
                                    </button>
                                    <form action="{{ route('author.posts.destroy', $post) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-light">No posts found.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
                {{ $posts->links() }}
            </div>

        </div>
    </section>
@endsection
