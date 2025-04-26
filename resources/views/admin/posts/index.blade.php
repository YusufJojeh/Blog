@extends('layouts.dash-lay')

@section('title', 'All Posts')

@section('content')
    <section class="content">
        <div class="container-fluid">

            {{-- Header --}}
            <div class="row mb-3">
                <div class="col-sm-6">
                    <h1>All Posts</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Create Post
                    </a>
                </div>
            </div>

            {{-- Alerts --}}
            @include('partials.alerts')

            {{-- Posts Table --}}
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-hover text-center mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Published At</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ Str::limit($post->title, 30) }}</td>
                                    <td>{{ $post->author?->name ?? '—' }}</td>
                                    <td>{{ $post->category?->name ?? '—' }}</td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $post->status === 'published' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                    </td>
                                    <td>{{ optional($post->published_at)->format('Y-m-d') ?? '—' }}</td>
                                    <td>
                                        @if ($post->image)
                                            <img src="{{ asset('storage/' . $post->image) }}" alt="thumb" width="50"
                                                height="40" class="img-thumbnail">
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-primary"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#deleteModal-{{ $post->id }}" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        {{-- Delete Confirmation Modal --}}
                                        <div class="modal fade" id="deleteModal-{{ $post->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="deleteModalLabel-{{ $post->id }}"
                                            aria-hidden="true">
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
                                                        Are you sure you want to delete post
                                                        “{{ Str::limit($post->title, 20) }}”?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-dismiss="modal">
                                                            Cancel
                                                        </button>
                                                        <form action="{{ route('admin.posts.destroy', $post) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- /Modal --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">No posts found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="card-footer clearfix">
                    {{ $posts->links() }}
                </div>
            </div>

        </div>
    </section>
@endsection
