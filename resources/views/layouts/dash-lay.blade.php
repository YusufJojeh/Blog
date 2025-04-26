<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard | Home')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        crossorigin="anonymous" />

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('css/OverlayScrollbars.min.css') }}" />

    <!-- AdminLTE Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}" />

    <!-- Custom overrides -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>
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

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3"
                    style="opacity:0.8" />
                <span class="brand-text font-weight-light">.Dev</span>
            </a>

            <div class="sidebar">
                <!-- User panel -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('images/user2-160x160.jpg') }}" class="img-circle elevation-2"
                            alt="User Image" />
                    </div>
                    @php
                        // 1) Detect which guard is logged in
                        $guards = ['admin', 'author', 'reader', 'web'];
                        $currentUser = null;
                        $currentGuard = null;
                        foreach ($guards as $g) {
                            if (Auth::guard($g)->check()) {
                                $currentUser = Auth::guard($g)->user();
                                $currentGuard = $g;
                                break;
                            }
                        }

                        // 2) Build the dashboard route name
                        $dashboardRoute = $currentGuard ? $currentGuard . '.dashboard' : 'dashboard';
                    @endphp
                    <div class="info">
                        <a href="#" class="d-block">
                            {{ $currentUser->name ?? 'Guest' }}
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route($dashboardRoute) }}"
                                class="nav-link {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- Admin Links -->
                        @if ($currentGuard === 'admin')
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p>User Management</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-newspaper"></i>
                                    <p>Article Management</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-tags"></i>
                                    <p>Categories & Tags</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-comments"></i>
                                    <p>Comments Management</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-cogs"></i>
                                    <p>Settings</p>
                                </a>
                            </li>

                            <!-- Author Links -->
                        @elseif($currentGuard === 'author')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-edit"></i>
                                    <p>My Articles</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p>Create New Article</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-comments"></i>
                                    <p>Comments on My Articles</p>
                                </a>
                            </li>

                            <!-- Reader Links -->
                        @elseif($currentGuard === 'reader')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-book"></i>
                                    <p>Browse Articles</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- /.Main Sidebar Container -->

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content pt-4">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        <footer class="main-footer text-center">
            <strong>&copy; {{ date('Y') }} My Dashboard</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.js') }}"></script>
    @stack('scripts')
</body>

</html>
