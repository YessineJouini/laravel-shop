@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Product Details -->
        <div class="col-lg-6 mb-4">
            <div class="border p-3 shadow-sm rounded-lg" style="max-width:600px;">
                <div class="ratio ratio-4x3 d-flex justify-content-center align-items-center bg-light product-image-zoom">
    <img 
        src="{{ Storage::url($product->image) }}" 
        class="rounded" 
        alt="{{ $product->name }}" 
        style="max-width: 100%; max-height: 100%; object-fit: contain;">
</div>

            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="product-details">
                <h1 class="display-5 fw-bold mb-3">{{ $product->name }}</h1>
                <p class="lead mb-4">{{ $product->description }}</p>
                
                <div class="mt-3 mb-4 d-flex align-items-center gap-3">
                    @if($product->sale && $product->sale->isActive())
                        <span class="h4 text-danger fw-bold">${{ number_format($product->discounted_price, 2) }}</span>
                        <small class="text-muted text-decoration-line-through">${{ number_format($product->price, 2) }}</small>
                    @else
                        <span class="h4 text-primary fw-bold">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                <!-- Stock Display -->
                <div class="mb-3">
                    @if($product->stock > 0)
                        <span class="badge bg-success fs-6">In Stock: {{ $product->stock }}</span>
                    @else
                        <span class="badge bg-danger fs-6">Out of Stock</span>
                    @endif
                </div>

                <div class="rating mb-4">
                    <div class="d-flex align-items-center">
                        <div class="stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa{{ $i <= round($product->reviews->avg('rating')) ? 's' : 'r' }} fa-star text-warning fa-lg"></i>
                            @endfor
                        </div>
                        <span class="ms-2 text-muted">({{ $product->reviews->count() }} reviews)</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('cart.add', $product->id) }}" class="mb-4">
                    @csrf
                    <button class="btn btn-primary btn-lg w-100" @if($product->stock == 0) disabled @endif>
                        <i class="fas fa-cart-plus me-2"></i>Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4 border-bottom pb-2">
                <i class="fas fa-comments me-2 text-primary"></i>Customer Reviews
            </h3>
            
           @foreach($product->reviews as $review)
    <div class="card mb-3 shadow-sm review-card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-2">
                <!-- User Avatar -->
                @if($review->user->avatar)
                    <img src="{{ Storage::url($review->user->avatar) }}" 
                         alt="{{ $review->user->name }}" 
                         class="rounded-circle me-3" 
                         style="width: 48px; height: 48px; object-fit: cover;">
                @else
                    <i class="fas fa-user-circle fa-2x text-secondary me-3"></i>
                @endif

                <div>
                    <strong class="fs-5">{{ $review->user->name }}</strong>
                    <div class="text-muted small">
                        {{ $review->created_at->format('M d, Y') }}
                    </div>
                </div>
            </div>
            <div class="rating mb-2">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star text-warning"></i>
                @endfor
            </div>
            <p class="mb-0">{{ $review->comment }}</p>
        </div>
    </div>
@endforeach

        </div>
    </div>

    <!-- Review Form -->
    @auth
    <div class="row mt-4">
        <div class="col-lg-8 offset-lg-2">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Write a Review
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="mb-4">
                            <label for="rating" class="form-label">Rating</label>
                            <select name="rating" id="rating" class="form-select form-select-lg">
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="comment" class="form-label">Comment</label>
                            <textarea name="comment" id="comment" rows="4" 
                                class="form-control" placeholder="Share your experience..." style="resize:none;"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-check-circle me-2"></i>Submit Review
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info mt-4">
        <i class="fas fa-info-circle me-2"></i>
        Please <a href="{{ route('login') }}" class="fw-bold text-decoration-underline">login</a> to leave a review.
    </div>
    @endauth
</div>
@endsection



