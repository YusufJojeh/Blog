<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    {{-- Page Title + Site Name --}}
    <title>@yield('title', 'Dashboard') – {{ $site_name ?? config('app.name') }}</title>

    {{-- Favicon --}}
    @if ($favicon)
        <link rel="shortcut icon" href="{{ asset('storage/' . $favicon) }}" type="image/png">
    @endif

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

    {{-- Custom CSS --}}
    @if ($custom_css)
        <style>
            {!! $custom_css !!}
        </style>
    @endif
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
    @stack('styles')
</head>

<body class="hold-transition sidebar-collapse layout-top-nav">
    <div class="wrapper">
        @php
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

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="{{ $currentGuard ? route($currentGuard . '.dashboard') : url('/') }}" class="navbar-brand">
                    @if ($logo)
                        <img src="{{ asset('storage/' . $logo) }}" alt="Logo"
                            class="brand-image img-circle elevation-3" style="opacity:.8">
                    @else
                        <img src="{{ asset('images/logo.png') }}" alt="Logo"
                            class="brand-image img-circle elevation-3" style="opacity:.8">
                    @endif
                    <span class="brand-text font-weight-light">{{ $site_name }}</span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Contact</a>
                        </li>
                    </ul>
                    <form class="form-inline ml-3">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#"><i
                                class="fas fa-expand-arrows-alt"></i></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown">
                            <img src="{{ $currentUser && $currentUser->profile_image ? asset('storage/' . $currentUser->profile_image) : asset('images/default.png') }}"
                                class="img-circle elevation-2" style="width:30px;height:30px;object-fit:cover;"
                                alt="User"> {{ $currentUser->name ?? 'Guest' }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route($currentGuard . '.profile.show') }}"><i
                                    class="far fa-user mr-2"></i>Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                    class="fas fa-sign-out-alt mr-2"></i>Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ $currentGuard ? route($currentGuard . '.dashboard') : url('/') }}"
                                class="nav-link {{ request()->routeIs($currentGuard . '.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        @if ($currentGuard === 'admin')
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p>User Management</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.categories.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tags"></i>
                                    <p>Category Management</p>
                                </a>
                            </li>
                            <li
                                class="nav-item has-treeview {{ request()->routeIs('admin.moderation.*') ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ request()->routeIs('admin.moderation.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-flag"></i>
                                    <p>Content Moderation<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item"><a href="{{ route('admin.moderation.reported-posts') }}"
                                            class="nav-link {{ request()->routeIs('admin.moderation.reported-posts') ? 'active' : '' }}"><i
                                                class="far fa-circle nav-icon"></i>
                                            <p>Reported Posts</p>
                                        </a></li>
                                    <li class="nav-item"><a href="{{ route('admin.moderation.reported-comments') }}"
                                            class="nav-link {{ request()->routeIs('admin.moderation.reported-comments') ? 'active' : '' }}"><i
                                                class="far fa-circle nav-icon"></i>
                                            <p>Reported Comments</p>
                                        </a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.settings.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-cogs"></i>
                                    <p>Site Settings</p>
                                </a>
                            </li>
                        @elseif($currentGuard === 'author')
                            <li
                                class="nav-item has-treeview {{ request()->routeIs('author.posts.*') ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ request()->routeIs('author.posts.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-edit"></i>
                                    <p>
                                        My Articles
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('author.posts.index') }}"
                                            class="nav-link ps-5 {{ request()->routeIs('author.posts.index') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>All Articles</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('author.posts.create') }}"
                                            class="nav-link ps-5 {{ request()->routeIs('author.posts.create') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Create Article</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('author.posts.drafts') }}"
                                            class="nav-link ps-5 {{ request()->routeIs('author.posts.drafts') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Drafts</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li
                                class="nav-item has-treeview {{ request()->routeIs('author.comments.*') ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ request()->routeIs('author.comments.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-comments"></i>
                                    <p>Comments<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('author.comments.index') }}"
                                            class="nav-link ps-5 {{ request()->routeIs('author.comments.index') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Comments on My Posts</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('author.comments.spam') }}"
                                            class="nav-link ps-5 {{ request()->routeIs('author.comments.spam') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Spam Reports</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>


                    </ul>
                    </li>
                @elseif($currentGuard === 'reader')
                    <li class="nav-item"><a href="{{ route('reader.feed') }}" class="nav-link"><i
                                class="nav-icon fas fa-rss"></i>
                            <p>My Feed</p>
                        </a></li>
                    <li class="nav-item"><a href="{{ route('reader.bookmarks.index') }}" class="nav-link"><i
                                class="nav-icon fas fa-bookmark"></i>
                            <p>Bookmarks</p>
                        </a></li>
                    <li class="nav-item"><a href="{{ route('reader.comments.index') }}" class="nav-link"><i
                                class="nav-icon fas fa-comments"></i>
                            <p>My Comments</p>
                        </a></li>
                    <li class="nav-item"><a href="{{ route('reader.search') }}" class="nav-link"><i
                                class="nav-icon fas fa-search"></i>
                            <p>Search Articles</p>
                        </a></li>
                    <li class="nav-item"><a href="{{ route('reader.preferences.edit') }}" class="nav-link"><i
                                class="nav-icon fas fa-sliders-h"></i>
                            <p>Preferences</p>
                        </a></li>
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

        <!-- Footer -->
        <footer class="main-footer text-center"><strong>&copy; {{ date('Y') }}
                {{ $site_name ?? config('app.name') }}</strong></footer>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script>
        $(function() {
            $('[data-widget="pushmenu"]').PushMenu();
        });
    </script>
    @stack('scripts')
</body>

</html>
