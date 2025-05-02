@extends('layouts.dash-lay')

@section('title', 'My Profile')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">My Profile</h3>
        </div>

        <form action="{{ route($guard . '.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">

                {{-- Avatar --}}
                <div class="form-group text-center">
                    <img src="{{ asset('storage/' . ($user->profile_image ?? 'default.png')) }}" class="img-circle mb-2"
                        style="width:100px;height:100px;object-fit:cover;" alt="Avatar">
                    <div>
                        <input type="file" name="profile_image" class="form-control-file" />
                    </div>
                </div>

                {{-- Name --}}
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label>New Password <small>(leave blank to keep current)</small></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
@endsection
