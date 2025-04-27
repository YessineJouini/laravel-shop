@extends('layouts.app')

@section('content')
<div class="container">
    <div class="alert alert-info">
        Please verify your email address. A verification link has been sent to <strong>{{ auth()->user()->email }}</strong>.
    </div>

    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            A new verification link has been sent!
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Resend Verification Email</button>
    </form>

    <a href="{{ route('store.index') }}" class="btn btn-secondary mt-3">Skip for now</a>

</div>
@endsection
