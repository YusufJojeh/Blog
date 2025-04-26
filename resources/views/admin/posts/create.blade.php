@extends('layouts.dash-lay')

@section('title', 'Create Post')

{{-- load any additional styles (e.g. CodeMirror theme) --}}
@push('styles')
    <!-- CodeMirror (optional) -->
    <link rel="stylesheet" href="{{ asset('plugins/codemirror/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/codemirror/theme/monokai.css') }}">
@endpush

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Post</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                @include('partials.alerts')

                <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Title --}}
                    <div class="form-group">
                        <label>Title</label>
                        <input name="title" type="text" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                            <option value="">— Select —</option>
                            @foreach ($categories as $id => $name)
                                <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Summernote Editor --}}
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Content</h3>
                        </div>
                        <div class="card-body">
                            <textarea id="summernote" name="content">
              {{ old('content') }}
            </textarea>
                        </div>
                        @error('content')
                            <div class="text-danger ml-3">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Image --}}
                    <div class="form-group">
                        <label for="image">Featured Image</label>
                        <input type="file" name="image" id="image" accept="image/*"
                            class="form-control-file @error('image') is-invalid @enderror">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status & Publish Date --}}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published"{{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Publish Date</label>
                            <input type="date" name="published_at" class="form-control"
                                value="{{ old('published_at') }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane"></i> Submit
                    </button>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- CodeMirror (optional) -->
    <script src="{{ asset('plugins/codemirror/codemirror.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/mode/css/css.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/mode/xml/xml.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>

    <script>
        $(function() {
            // Summernote
            $('#summernote').summernote({
                height: 300
            });

            // If you want CodeMirror for a second textarea:
            // CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
            //   mode: "htmlmixed",
            //   theme: "monokai"
            // });
        });
    </script>
@endpush
