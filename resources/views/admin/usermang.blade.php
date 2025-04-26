@extends('layouts.dash-lay')

@section('title', 'Admin Management')

@section('content')
    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">
            + New User
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title" style="color:#000 !important;">All System Users</h3>
        </div>
        <div class="card-body p-0">
            <table class=" table table-bordered table-hover mb-0">
                <thead class='table-center table-primary text-black fw-bold'>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $u)
                        <tr>
                            <td>{{ $u['id'] }}</td>
                            <td>{{ $u['name'] }}</td>
                            <td>{{ $u['email'] }}</td>
                            <td class="text-capitalize">{{ $u['role'] }}</td>
                            <td>
                                <a href="{{ route('admin.users.show', [$u['role'], $u['id']]) }}"
                                    class="btn btn-xs btn-info">View</a>

                                <a href="{{ route('admin.users.edit', [$u['role'], $u['id']]) }}"
                                    class="btn btn-xs btn-primary">Edit</a>

                                <form action="{{ route('admin.users.destroy', [$u['role'], $u['id']]) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-danger"
                                        onclick="return confirm('Delete this {{ $u['role'] }}?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
