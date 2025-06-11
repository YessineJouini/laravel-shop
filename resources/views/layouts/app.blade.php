<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <link href="{{ asset('assets/img/Logo.ico') }}" rel="icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.bunny.net">
  
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
      <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">

  <!-- Scripts -->
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])

  <style>
    /* Push content below fixed navbar (height ~56px) */
    body { padding-top: 56px; }
    .nav-link.active {
  border-left: 2px solid rgb(27, 181, 247); 
  padding-left: 0.75rem;  
          
  border-top-left-radius: 8px;
  border-bottom-left-radius: 8px;      
      
  font-weight: bold;
}
  </style>
</head>
<body>
  {{-- filepath: resources/views/layouts/app.blade.php --}}
{{-- ...existing code... --}}
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
{{-- ...existing code... --}}
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
    <a class="nav-link {{ request()->routeIs('store.index') ? 'active' : '' }}" href="{{ route('store.index') }}">
      Store
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
      Dashboard
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('wishlist.index') ? 'active' : '' }}" href="{{ route('wishlist.index') }}">
      Wishlist
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-danger {{ request()->routeIs('sales.view') ? 'active fw-bold' : '' }}" href="{{ route('sales.view') }}">
      Sales
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('cart.view') ? 'active' : '' }}" href="{{ route('cart.view') }}">
      My Cart
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('chatbot.index') ? 'active' : '' }}" href="{{ route('chatbot.index') }}" style="color: #00c2ed;">
      ByteBuddy
    </a>
  </li>

  @auth
    @if(Auth::user()->isAdmin())
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}" href="{{ route('orders.index') }}">
          Manage Orders
        </a>
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
                  <a class="dropdown-item" href="/profile">
                    {{ __('Profile') }}
                    
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
  <a href="{{ route('cart.view') }}"
   class="btn btn-info btn-lg rounded-circle shadow position-fixed d-flex align-items-center justify-content-center"
   style="bottom:20px; right:20px; width:60px; height:60px;">
  {{-- White cart icon --}}
  <!-- Footer Section -->

  <i class="fas fa-shopping-cart fa-lg text-white"></i>

  @auth
    @php
      $count = Auth::user()->cart?->items->sum('quantity') ?? 0;
    @endphp
    @if($count)

      <span class="badge badge-pill position-absolute"
            style="top:-6px; right:-6px; font-size:0.75rem; background-color:red; color:white;">
        {{ $count }}
      </span>
    @endif
  @endauth
</a>
    @stack('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</body>
</html>
