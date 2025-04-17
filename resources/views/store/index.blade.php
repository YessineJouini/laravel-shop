@extends('store.layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Store</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Products</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($products as $product)
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="card h-100 product-card">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top product-image" alt="{{ $product->name }}">
                                    <div class="card-body p-2">
                                        <h5 class="card-title mb-1">{{ $product->name }}</h5>
                                        <p class="card-text small mb-1">{{ Str::limit($product->description, 50) }}</p>
                                        <p class="card-text mb-2"><strong>${{ number_format($product->price, 2) }}</strong></p>
                                        <a href="{{ route('store.show', $product->id) }}" class="btn btn-primary btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.product-card {
    transition: transform 0.2s;
}
.product-card:hover {
    transform: translateY(-5px);
}
.product-image {
    height: 150px;
    object-fit: cover;
}
</style>
@endsection 