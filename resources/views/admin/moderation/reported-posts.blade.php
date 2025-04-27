@extends('layouts.dash-lay')

@section('title', 'Reported Posts')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Reported Posts</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Flagged At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ Str::limit($post->title, 40) }}</td>
                            <td>{{ $post->author->name }}</td>
                            <td>{{ $post->updated_at->format('Y-m-d') }}</td>
                            <td class="d-flex">
                                <form action="{{ route('admin.moderation.reported-posts.unflag', $post) }}" method="POST"
                                    class="mr-1">
                                    @csrf
                                    <button class="btn btn-sm btn-success">Unflag</button>
                                </form>
                                <form action="{{ route('admin.moderation.reported-posts.delete', $post) }}" method="POST"
                                    onsubmit="return confirm('Delete this post?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No reported posts.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
