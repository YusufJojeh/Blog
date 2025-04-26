{{-- resources/views/admin/usermang_edit.blade.php --}}
@extends('layouts.dash-lay')

@section('title', 'Edit User')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit User: {{ $user->name }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', [$role, $user->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                        value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="author" {{ $user->role === 'author' ? 'selected' : '' }}>Author</option>
                        <option value="reader" {{ $user->role === 'reader' ? 'selected' : '' }}>Reader</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password <small>(leave blank to keep)</small></label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="New password">
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        placeholder="Confirm new password">
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
@endsection
