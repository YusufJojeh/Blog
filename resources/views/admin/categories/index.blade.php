@extends('layouts.dash-lay')

@section('title', 'Category Management')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Categories</h3>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">New Category</a>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                        <tr>
                            <td>{{ $cat->id }}</td>
                            <td>{{ $cat->name }}</td>
                            <td>
                                @if ($cat->image)
                                    <img src="{{ asset('storage/' . $cat->image) }}" alt=""
                                        style="height:40px;width:40px;object-fit:cover;border-radius:4px;">
                                @endif
                            </td>
                            <td>{{ $cat->created_at->format('Y-m-d') }}</td>
                            <td>{{ $cat->updated_at->format('Y-m-d') }}</td>
                            <td class="d-flex">
                                <a href="{{ route('admin.categories.edit', $cat) }}"
                                    class="btn btn-sm btn-warning mr-1">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST"
                                    onsubmit="return confirm('Delete this?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $categories->links() }}
        </div>
    </div>
@endsection
