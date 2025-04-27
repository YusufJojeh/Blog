@extends('layouts.dash-lay')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container-fluid">
        {{-- KPI Cards --}}
        <div class="row">
            {{-- Total Users --}}
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $userStats['total'] }}</h3>
                        <p>Total Users</p>
                    </div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            {{-- Published Posts --}}
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $postStats['published'] }}</h3>
                        <p>Published Posts</p>
                    </div>
                    <div class="icon"><i class="fas fa-file-alt"></i></div>
                    <a href="{{ route('admin.posts.index') }}" class="small-box-footer">
                        Manage posts <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            {{-- Pending Comments --}}
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $commentStats['pending'] }}</h3>
                        <p>Pending Comments</p>
                    </div>
                    <div class="icon"><i class="fas fa-comments"></i></div>
                    <a href="" class="small-box-footer">
                        Review comments <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            {{-- New Registrations --}}
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $newRegistrations }}</h3>
                        <p>New Registrations (7 days)</p>
                    </div>
                    <div class="icon"><i class="fas fa-user-plus"></i></div>
                    <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                        View users <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Charts --}}
        <div class="row">
            {{-- Posts per Day --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Posts Per Day</h3>
                    </div>
                    <div class="card-body"><canvas id="posts-chart"></canvas></div>
                </div>
            </div>
            {{-- User Sign-ups --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>User Sign-ups</h3>
                    </div>
                    <div class="card-body"><canvas id="users-chart"></canvas></div>
                </div>
            </div>
        </div>

        {{-- Recent Posts --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Latest Posts</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th>Published</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentPosts as $post)
                                    <tr>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->author->name }}</td>
                                        <td>{{ ucfirst($post->status) }}</td>
                                        <td>{{ $post->published_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('admin.posts.edit', $post) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button onclick="return confirm('Are you sure?')"
                                                    class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Build posts data
        const postsLabels = Object.keys(@json($postsPerDay));
        const postsData = Object.values(@json($postsPerDay));
        new Chart(document.getElementById('posts-chart'), {
            type: 'line',
            data: {
                labels: postsLabels,
                datasets: [{
                    label: 'Posts',
                    data: postsData
                }]
            }
        });

        // Build users data
        const usersLabels = Object.keys(@json($userSignUps));
        const usersData = Object.values(@json($userSignUps));
        new Chart(document.getElementById('users-chart'), {
            type: 'bar',
            data: {
                labels: usersLabels,
                datasets: [{
                    label: 'Sign-ups',
                    data: usersData
                }]
            }
        });
    </script>
@endpush
