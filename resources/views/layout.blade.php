<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'HyperByte') }} – @yield('title', 'Dashboard')</title>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" rel="stylesheet">
    <link href="{{ asset('assets/img/Logo.ico') }}" rel="icon">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('vendor/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('vendor/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('vendor/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterangepicker -->
    <link rel="stylesheet" href="{{ asset('vendor/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Summernote -->
    <link rel="stylesheet" href="{{ asset('vendor/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <!-- Custom -->
    <link rel="stylesheet" href="{{ asset('assets/css/mainstyle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/frontend.css') }}">


</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <!-- Sidebar toggle-->
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars fa-lg"></i></a>
            </li>
            <!-- Home -->
            <li class="nav-item">
              <a class="nav-link" href="{{ route('store.index') }}">Store</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-danger" href="{{ route('sales.view') }}">Sales</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Whishlist</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('cart.view') }}">My Cart</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <!-- Search toggle -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#"><i class="fas fa-search"></i></a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit"><i class="fas fa-search"></i></button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <!-- Messages Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <div class="media">
                            <img src="{{ asset('vendor/adminlte/dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">Brad Diesel<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span></h3>
                                <p class="text-sm">Call me whenever you can...</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>4 Hours Ago</p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>

            <!-- Notifications Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#"><i class="far fa-bell"></i><span class="badge badge-warning navbar-badge">15</span></a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item"><i class="fas fa-envelope mr-2"></i>4 new messages<span class="float-right text-muted text-sm">3 mins</span></a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>

            <!-- Fullscreen -->
            <li class="nav-item"><a class="nav-link" data-widget="fullscreen" href="#"><i class="fas fa-expand-arrows-alt"></i></a></li>
            <!-- Control Sidebar -->
            <li class="nav-item"><a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#"><i class="fas fa-th-large"></i></a></li>

            <!-- Logout -->
            <li class="nav-item ml-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->


    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{ asset('vendor/adminlte/dist/img/minilogo.png') }}" alt="HyperByte Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span style="color: #00c2ed; font-weight: 700;">H</span><span style="color:rgb(255, 255, 255); font-weight:300;">yperByte</span>
        </a>

        <div class="sidebar">
            <!-- User panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('vendor/adminlte/dist/img/user1-128x128.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="{{ route('dashboard') }}" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>

         <!-- Sidebar Menu -->
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

    <!-- Dashboard -->
    <li class="nav-item">
      <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
      </a>
    </li>

    <!-- Analytics -->
    <li class="nav-item">
      <a href="{{ route('admin.analytics') }}" class="nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chart-line"></i>
        <p>Analytics</p>
      </a>
    </li>

    <!-- Orders -->
    <li class="nav-item">
      <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">
        <i class="nav-icon fas fa-box"></i>
        <p>Orders</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('sales.index') }}" class="nav-link {{ request()->routeIs('sales.index') ? 'active' : '' }}">
        <i class="nav-icon fas fa-percent"></i>
        <p>Sales</p>
      </a>
    </li>
    
    <li class="nav-item">
  <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}">
    <i class="nav-icon fas fa-tags"></i>
    <p>Categories</p>
  </a>
</li>


    <!-- Products -->
    <li class="nav-item">
      <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tags"></i>
        <p>Products</p>
      </a>
    </li>

  </ul>
</nav>
<!-- /.sidebar-menu -->

        </div>
    </aside>
    <!-- /.sidebar -->


    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid px-0">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>@yield('header', 'Dashboard')</h1></div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid px-0">
                @yield('content')
            </div>
        </section>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger m-3">{{ session('error') }}</div>
        @endif
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    <footer class="main-footer text-sm">
        <strong>&copy; {{ date('Y') }} <a href="{{ route('admin.dashboard') }}">{{ config('app.name', 'HyperByte') }}</a>.</strong> All rights reserved.
        <div class="float-right d-none d-sm-inline-block"><b>Version</b> 3.2.0</div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
<!-- ./wrapper -->


<!-- REQUIRED SCRIPTS -->
<script src="{{ asset('vendor/jquery/jquery.js') }}"></script>
<script src="{{ asset('vendor/plugins/jquery-ui/jquery-ui.js') }}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('vendor/plugins/chart.js/chart.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>

<!-- OPTIONAL PLUGINS -->
<script src="{{ asset('vendor/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('vendor/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('vendor/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('vendor/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<script src="{{ asset('vendor/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('vendor/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/demo.js') }}"></script>

@if(Route::is('admin.dashboard'))
    <script src="{{ asset('vendor/adminlte/dist/js/pages/dashboard.js') }}"></script>
@endif

@yield('js')


</body>
</html>
