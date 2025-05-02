@extends('layouts.dash-lay')

@section('title', 'Author Dashboard')

@section('content')
    <div class="container-fluid">
        {{-- KPI Cards --}}
        <div class="row">
            {{-- Total Posts --}}
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalPosts }}</h3>
                        <p>Total Posts</p>
                    </div>
                    <div class="icon"><i class="fas fa-file-alt"></i></div>
                    <a href="{{ route('author.posts.index') }}" class="small-box-footer">
                        Manage posts <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            {{-- Published --}}
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $published }}</h3>
                        <p>Published Posts</p>
                    </div>
                    <div class="icon"><i class="fas fa-check-circle"></i></div>
                    <a href="{{ route('author.posts.index', ['status' => 'published']) }}" class="small-box-footer">
                        View published <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            {{-- Drafts --}}
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $drafts }}</h3>
                        <p>Draft Posts</p>
                    </div>
                    <div class="icon"><i class="fas fa-pencil-alt"></i></div>
                    <a href="{{ route('author.posts.drafts') }}" class="small-box-footer">
                        View drafts <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            {{-- Spam Reports --}}
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $spamCount }}</h3>
                        <p>Spam Reports</p>
                    </div>
                    <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                    <a href="{{ route('author.comments.spam') }}" class="small-box-footer">
                        Review spam <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Charts --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Engagement Trends (Last 7 Days)</h3>
                    </div>
                    <div class="card-body"><canvas id="engagement-chart"></canvas></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = {!! json_encode($engagement->pluck('date')) !!};
        const data = {!! json_encode($engagement->pluck('count')) !!};
        new Chart(document.getElementById('engagement-chart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Comments',
                    data: data,
                    fill: false,
                    tension: 0.1
                }]
            }
        });
    </script>
@endpush
