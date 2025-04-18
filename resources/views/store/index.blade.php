@extends('layouts.store')

@section('title', 'Store')

@section('content')
<div class="container-fluid">
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100 product-card">
                    <div class="card-img-container">
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text flex-grow-1">{{ Str::limit($product->description, 100) }}</p>
                        <div class="mt-auto">
                            <p class="card-text price"><strong>${{ number_format($product->price, 2) }}</strong></p>
                            <a href="#" class="btn btn-primary btn-block">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
.product-card {
    transition: transform 0.2s;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border: none;
    border-radius: 8px;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.card-img-container {
    height: 200px;
    overflow: hidden;
    border-radius: 8px 8px 0 0;
}

.card-img-top {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.card-body {
    padding: 1.25rem;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.card-text {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.price {
    color: #28a745;
    font-size: 1.2rem;
    margin-bottom: 1rem;
}

.btn-primary {
    background-color: #007bff;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    transition: background-color 0.2s;
}

.btn-primary:hover {
    background-color: #0056b3;
}
</style>
@endsection 