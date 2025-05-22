{{-- resources/views/errors/404.blade.php --}}
@extends('layouts.app')

@section('title', '404 Not Found')

@section('content_header')
    <h1 class="display-4 fw-bold" style="color: #00c2ed;">HyperByte</h1>
@stop

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 60vh;">
    <h1 class="display-1 fw-bold" style="color: #00c2ed;">404</h1>
    <p class="lead fw-light" style="color: #333;">
        Let’s call this a ‘feature’.
    </p>
    <a href="{{ url('/') }}" class="btn btn-primary" style="background-color: #00c2ed; border-color: #00c2ed;">
        Back to Home
    </a>
</div>
@stop
