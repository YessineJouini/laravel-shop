{{-- resources/views/errors/403.blade.php --}}
@extends('layouts.app')

@section('title', '403 Access Denied')

@section('content_header')
    <h1 class="display-4 fw-bold" style="color: #00c2ed;">HyperByte</h1>
@stop

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 60vh;">
    <h1 class="display-1 fw-bold" style="color: #00c2ed;">Yikes</h1>
    <p class="lead fw-semibold" style="color: #333;">
        Access denied.
    </p>
    <p class="text-muted mb-4" style="max-width: 400px; text-align: center;">
        You don’t have clearance for this area, nice try though.
    </p>
    <a href="{{ url('/') }}" class="btn btn-primary" style="background-color: #00c2ed; border-color: #00c2ed;">
        Back to Home
    </a>
</div>
@stop
