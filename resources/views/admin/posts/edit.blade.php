@extends('layouts.dash-lay')

@section('title', 'Edit Post')

@section('content')
    <section class="content">
        <div class="container-fluid">

            {{-- Header --}}
            <div class="row mb-3">
                <div class="col-sm-6">
                    <h1>Edit Post</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Posts
                    </a>
                </div>
            </div>

            {{-- Alerts --}}
            @include('partials.alerts')

            {{-- Card --}}
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Post #{{ $post->id }}</h3>
                        </div>

                        <form method="POST" action="{{ route('admin.posts.update', $post) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                {{-- Title --}}
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input id="title" name="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title', $post->title) }}" placeholder="Enter post title">
                                    @error('title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Category --}}
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select id="category_id" name="category_id"
                                        class="form-control @error('category_id') is-invalid @enderror">
                                        <option value="">— Select Category —</option>
                                        @foreach ($categories as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ old('category_id', $post->category_id) == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Content (Summernote) --}}
                                <div class="form-group">
                                    <label>Content</label>
                                    <div class="card card-outline card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">Write Content</h3>
                                        </div>
                                        <div class="card-body p-0">
                                            <textarea id="summernote" name="content">
                      {{ old('content', $post->content) }}
                    </textarea>
                                        </div>
                                    </div>
                                    @error('content')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Author --}}
                                <div class="form-group">
                                    <label for="author_id">Author</label>
                                    <select id="author_id" name="author_id"
                                        class="form-control @error('author_id') is-invalid @enderror">
                                        <option value="">— Select Author —</option>
                                        @foreach ($authors as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ old('author_id', $post->author_id) == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('author_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Current Image --}}
                                @if ($post->image)
                                    <div class="form-group">
                                        <label>Current Image</label>
                                        <div>
                                            <img src="{{ asset('storage/' . $post->image) }}" class="img-thumbnail"
                                                width="150" alt="Current image">
                                        </div>
                                    </div>
                                @endif

                                {{-- Image Upload --}}
                                <div class="form-group">
                                    <label for="image">Change Image</label>
                                    <div class="custom-file">
                                        <input type="file" id="image" name="image" accept="image/*"
                                            class="custom-file-input @error('image') is-invalid @enderror">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                    @error('image')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Status & Publish Date --}}
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="status">Status</label>
                                        <select id="status" name="status"
                                            class="form-control @error('status') is-invalid @enderror">
                                            <option value="draft"
                                                {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft
                                            </option>
                                            <option
                                                value="published"{{ old('status', $post->status) == 'published' ? 'selected' : '' }}>
                                                Published</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="published_at">Publish Date</label>
                                        <input id="published_at" name="published_at" type="date"
                                            class="form-control @error('published_at') is-invalid @enderror"
                                            value="{{ old('published_at', optional($post->published_at)->format('Y-m-d')) }}">
                                        @error('published_at')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Update Post
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Summernote init
        $('#summernote').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });

        // Show filename in custom-file-input
        document.querySelectorAll('.custom-file-input').forEach(input => {
            input.addEventListener('change', function() {
                const name = this.files[0]?.name || 'Choose file';
                this.nextElementSibling.innerText = name;
            });
        });
    </script>
@endpush
