@extends('layouts.app')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <!-- Brand Header -->
      <div class="text-center mb-4">
        <h1 class="display-4 fw-bold" style="color: #00c2ed;">HyperByte</h1>
        <p class="text-muted">Create your account</p>
      </div>

      <div class="card shadow border-0 rounded-3">
        <div class="card-body p-4">
          <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input
                id="name"
                type="text"
                class="form-control form-control-lg @error('name') is-invalid @enderror"
                name="name"
                value="{{ old('name') }}"
                required
                autocomplete="name"
                autofocus
                placeholder="Your full name"
              >
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

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
                autocomplete="new-password"
                placeholder="Choose a secure password"
              >
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-4">
              <label for="password-confirm" class="form-label">Confirm Password</label>
              <input
                id="password-confirm"
                type="password"
                class="form-control form-control-lg"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Re-enter your password"
              >
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-lg text-white" style="background-color: #00c2ed;">
                <i class="fas fa-user-plus me-2"></i> Register
              </button>
            </div>
          </form>
        </div>
      </div>

      <p class="text-center text-muted mt-3">
        Already have an account?
        <a href="{{ route('login') }}" style="color: #00c2ed;">Log In</a>
      </p>
    </div>
  </div>
</div>
@endsection
