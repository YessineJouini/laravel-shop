@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Product Details -->
        <div class="col-lg-6 mb-4">
          <div class="border p-3 shadow-sm rounded-lg" style="max-width:600px;">
                    <div class="ratio ratio-4x3">
                        <img 
                        src="{{ Storage::url($product->image) }}" 
                        class="rounded" 
                        alt="{{ $product->name }}" 
                        style="object-fit: cover; width: 100%; height: 100%;">
                    </div>
</div>

        </div>
        <div class="col-lg-6 mb-4">
            <div class="product-details">
                <h1 class="display-5 fw-bold mb-3">{{ $product->name }}</h1>
                <p class="lead mb-4">{{ $product->description }}</p>
                
                <div class="d-flex align-items-center mb-4">
                    <h3 class="text-success me-3">${{ number_format($product->price, 2) }}</h3>
                    <span class="badge bg-primary fs-6">In Stock</span>
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

                <form method="POST" action="{{ route('cart.add', $product->id) }}">
                    @csrf
                    <button class="btn btn-primary btn-lg">
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
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-user-circle fa-2x text-secondary me-3"></i>
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
                                class="form-control" placeholder="Share your experience..."></textarea>
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
        Please <a href="{{ route('login') }}">login</a> to leave a review.
    </div>
    @endauth
</div>
@endsection
