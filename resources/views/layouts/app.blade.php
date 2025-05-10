<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <link href="{{ asset('assets/img/Logo.ico') }}" rel="icon">
  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
  <!-- Scripts -->
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])

  <style>
    /* Push content below fixed navbar (height ~56px) */
    body { padding-top: 56px; }
  </style>
</head>
<body>
  <div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
      <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ url('/') }}" style="font-size: 1.4rem;">
          <span style="color: #00c2ed; font-weight: 800">H</span><span style="color: #000; font-weight:200;">yperByte</span>
        </a>
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('store.index') }}">Store</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="{{ route('wishlist.index') }}">Wishlist</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-danger" href="{{ route('sales.view') }}">Sales</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('cart.view') }}">My Cart</a>
            </li>

            @auth
              @if(Auth::user()->isAdmin())
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('orders.index') }}">Manage Orders</a>
                </li>
              @endif
            @endauth
          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ms-auto">
            @guest
              @if (Route::has('login'))
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}" style="color: #00c2ed;">
                                  {{ __('Login') }}
                </a>

                </li>
              @endif
              @if (Route::has('register'))
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
              @endif
            @else
              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                   role="button" data-bs-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ url('/dashboard') }}">
                    {{ __('Dashboard') }}
                  </a>
                  <a class="dropdown-item" href="#">
                    {{ __('Account Settings') }}
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}"
                        method="POST" class="d-none">
                    @csrf
                  </form>
                </div>
              </li>
            @endguest
          </ul>
        </div>
      </div>
    </nav>

    <main class="py-4 container">
      @yield('content')
    </main>
  </div>
</body>
</html>
