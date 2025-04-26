{{-- resources/views/admin/usermang_show.blade.php --}}
@extends('layouts.dash-lay')

@section('title', 'User Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User Details: {{ $user->name }}</h3>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item"><strong>ID:</strong> {{ $user->id }}</li>
                <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                <!-- Corrected the access to the 'role' -->
                <li class="list-group-item"><strong>Role:</strong> {{ ucfirst($role) }}</li>
            </ul>
            <div class="mt-3">
                <a href="{{ route('admin.users.edit', [$role, $user->id]) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('admin.users.destroy', [$role, $user->id]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Delete this user?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection
