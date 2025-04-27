{{-- resources/views/layouts/dash-lay.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard | Home')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}" />
    <!-- Summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}" />
    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}" />
    <!-- Custom -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        {{-- Navbar --}}
        <nav class="main-header navbar navbar-expand navbar-dark">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        @php
            // Determine guard & user
            $currentGuard = null;
            $currentUser = null;
            foreach (['admin', 'author', 'reader'] as $g) {
                if (Auth::guard($g)->check()) {
                    $currentGuard = $g;
                    $currentUser = Auth::guard($g)->user();
                    break;
                }
            }
        @endphp

        <!-- Main Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="{{ asset('images/logo.png') }}" class="brand-image img-circle elevation-3" style="opacity:.8"
                    alt="Logo">
                <span class="brand-text font-weight-light">.Dev</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" data-accordion="false">

                        {{-- User panel --}}
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <img src="{{ asset('images/' . ($currentUser->profile_image ?? 'default.png')) }}"
                                    class="img-circle elevation-2"
                                    style="width:36px; height:36px; object-fit:cover; border-radius:50%; border:2px solid #fff;"
                                    alt="User Avatar">
                                <p class="ps-3 mb-0 d-inline-block">
                                    {{ $currentUser->name ?? 'Guest' }}
                                    <i class="fas fa-angle-down float-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link ps-5">
                                        <i class="far fa-user nav-icon"></i>
                                        <p>Profile</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link ps-5"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt nav-icon"></i>
                                        <p>Logout</p>
                                    </a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </ul>
                        </li>

                        {{-- Dashboard Link --}}
                        <li class="nav-item">
                            <a href="#"
                                class="nav-link {{ request()->routeIs("{$currentGuard}.dashboard") ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        {{-- Admin Menu --}}
                        @if ($currentGuard === 'admin')
                            {{-- User Management --}}
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p>User Management</p>
                                </a>
                            </li>

                            {{-- Category Management --}}
                            <li class="nav-item">
                                <a href="{{ route('admin.categories.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-tags"></i>
                                    <p>Category Management</p>
                                </a>
                            </li>

                            {{-- Content Moderation --}}
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-flag"></i>
                                    <p>
                                        Content Moderation
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.moderation.reported-posts') }}" class="nav-link ps-5">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Reported Posts</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.moderation.reported-comments') }}"
                                            class="nav-link ps-5">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Reported Comments</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            {{-- Site Settings --}}
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-cogs"></i>
                                    <p>Site Settings</p>
                                </a>
                            </li>

                            {{-- Reports & Analytics --}}
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-chart-pie"></i>
                                    <p>
                                        Reports & Analytics
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="" class="nav-link ps-5">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Content Reports</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="" class="nav-link ps-5">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>User Activity</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            {{-- Author Menu --}}
                        @elseif($currentGuard === 'author')
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-edit"></i>
                                    <p>
                                        My Articles
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link ps-5">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>All Articles</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link ps-5">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Create Article</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link ps-5">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Drafts</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link ps-5">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Scheduled</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-comments"></i>
                                    <p>
                                        Comments
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link ps-5">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Comments on My Posts</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link ps-5">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Spam Reports</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>
                                        Analytics
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link ps-5">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Post Stats</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link ps-5">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Engagement Trends</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>My Profile</p>
                                </a>
                            </li>

                            {{-- Reader Menu --}}
                        @elseif($currentGuard === 'reader')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-rss"></i>
                                    <p>My Feed</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-bookmark"></i>
                                    <p>Bookmarks</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-comments"></i>
                                    <p>My Comments</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-search"></i>
                                    <p>Search Articles</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-sliders-h"></i>
                                    <p>Preferences</p>
                                </a>
                            </li>
                        @endif

                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content pt-4">
                <div class="container-fluid">@yield('content')</div>
            </section>
        </div>

        <!-- Main Footer -->
        <footer class="main-footer text-center">
            <strong>&copy; {{ date('Y') }} My Dashboard</strong>
        </footer>
    </div>

    <!-- REQUIRED SCRIPTS -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script>
        $(function() {
            $('[data-widget="treeview"]').Treeview('init');
            $('[data-toggle="dropdown"]').dropdown();
        });
    </script>
    @stack('scripts')
</body>

</html>
