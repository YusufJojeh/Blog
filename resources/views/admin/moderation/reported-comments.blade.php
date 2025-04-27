@extends('layouts.dash-lay')

@section('title', 'Reported Comments')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Reported Comments</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Excerpt</th>
                        <th>Post</th>
                        <th>User</th>
                        <th>Flagged At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $c)
                        <tr>
                            <td>{{ $c->id }}</td>
                            <td>{{ Str::limit($c->content, 30) }}</td>
                            <td>{{ $c->post->title }}</td>
                            <td>{{ $c->user->name }}</td>
                            <td>{{ $c->updated_at->format('Y-m-d') }}</td>
                            <td class="d-flex">
                                <form action="{{ route('admin.moderation.reported-comments.unflag', $c) }}" method="POST"
                                    class="mr-1">
                                    @csrf
                                    <button class="btn btn-sm btn-success">Unflag</button>
                                </form>
                                <form action="{{ route('admin.moderation.reported-comments.delete', $c) }}" method="POST"
                                    onsubmit="return confirm('Delete this comment?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No reported comments.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $comments->links() }}
        </div>
    </div>
@endsection
