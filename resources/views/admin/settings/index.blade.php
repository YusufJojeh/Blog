@extends('layouts.dash-lay')

@section('title', 'Site Settings')

@push('styles')
    <style>
        .preview-img {
            max-height: 100px;
            margin-bottom: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Site Settings</h3>
        </div>
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                {{-- Site Name --}}
                <div class="form-group">
                    <label for="site_name">Site Name</label>
                    <input type="text" id="site_name" name="site_name"
                        class="form-control @error('site_name') is-invalid @enderror"
                        value="{{ old('site_name', $data['site_name']) }}">
                    @error('site_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Logo --}}
                <div class="form-group">
                    <label for="logo">Logo</label><br>
                    @if ($data['logo'])
                        <img src="{{ asset('storage/' . $data['logo']) }}" class="preview-img" alt="Logo Preview">
                    @endif
                    <input type="file" id="logo" name="logo"
                        class="form-control-file @error('logo') is-invalid @enderror">
                    @error('logo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Favicon --}}
                <div class="form-group">
                    <label for="favicon">Favicon (32×32)</label><br>
                    @if ($data['favicon'])
                        <img src="{{ asset('storage/' . $data['favicon']) }}" class="preview-img" alt="Favicon Preview">
                    @endif
                    <input type="file" id="favicon" name="favicon"
                        class="form-control-file @error('favicon') is-invalid @enderror">
                    @error('favicon')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Custom CSS --}}
                <div class="form-group">
                    <label for="custom_css">Custom CSS</label>
                    <textarea id="custom_css" name="custom_css" rows="5"
                        class="form-control @error('custom_css') is-invalid @enderror">{{ old('custom_css', $data['custom_css']) }}</textarea>
                    @error('custom_css')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
@endsection
