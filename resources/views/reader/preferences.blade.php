@extends('layouts.dash-lay')
@section('title', 'Preferences')
@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST">
        @csrf
        <div class="form-group">
            <label>Preferred Categories</label>
            <select name="categories[]" multiple class="form-control">
                @foreach (\App\Models\Category::all() as $cat)
                    <option value="{{ $cat->id }}" @if (in_array($cat->id, json_decode($pref->categories, true))) selected @endif>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="email_notifications" value="1" class="form-check-input"
                @if ($pref->email_notifications) checked @endif>
            <label class="form-check-label">Email Notifications</label>
        </div>
        <button class="btn btn-primary">Save</button>
    </form>
@endsection
