@extends('layouts.app')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="text-center mb-4">
        <h1 class="display-4 fw-bold" style="color: #00c2ed;">HyperByte</h1>
        <p class="text-muted">Log in to power your shopping experience</p>
      </div>

      <div class="card shadow border-0 rounded-3">
        <div class="card-body p-4">
          <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input
                id="email"
                type="email"
                class="form-control form-control-lg @error('email') is-invalid @enderror"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="email"
                autofocus
                placeholder="you@example.com"
              >
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input
                id="password"
                type="password"
                class="form-control form-control-lg @error('password') is-invalid @enderror"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Enter your password"
              >
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  name="remember"
                  id="remember"
                  {{ old('remember') ? 'checked' : '' }}
                >
                <label class="form-check-label" for="remember">Remember Me</label>
              </div>
              @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="small" style="color: #00c2ed;">
                  Forgot your password?
                </a>
              @endif
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-lg text-white" style="background-color: #00c2ed;">
                <i class="fas fa-sign-in-alt me-2"></i> Log In
              </button>
            </div>
          </form>
        </div>
      </div>

      <p class="text-center text-muted mt-3">
        Don’t have an account? 
        <a href="{{ route('register') }}" style="color: #00c2ed;">Sign Up</a>
      </p>
    </div>
  </div>
</div>
@endsection
