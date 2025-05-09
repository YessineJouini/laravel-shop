
@extends($layout)

@section('title', 'Store')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1 class="mb-3">Product Catalog</h1>
    </div> 
  </section>

  <!-- Filter Bar -->
  <div class="card card-outline card-primary mb-4">
    <div class="card-header bg-primary">
      <h3 class="card-title text-white">
        <i class="fas fa-filter mr-2"></i>Filter Products
      </h3>
    </div>
    <div class="card-body p-2">
      <form method="GET" action="{{ route('store.index') }}">
        <div class="d-flex flex-wrap align-items-center justify-content-start">

          <!-- Search -->
          <div class="me-2 mb-2">
            <div class="input-group input-group-sm">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
              <input type="text" name="search" class="form-control"
                     placeholder="Search..." value="{{ request('search') }}">
            </div>
          </div>

          <!-- Category -->
          <div class="me-2 mb-2">
            <select name="category" class="form-control form-control-sm">
              <option value="">All Categories</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                  {{ $cat->name }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Min Price -->
          <div class="me-2 mb-2">
            <input type="number" name="min_price" class="form-control form-control-sm"
                   placeholder="Min $" min="0" step="0.01" value="{{ request('min_price') }}">
          </div>

          <!-- Max Price -->
          <div class="me-2 mb-2">
            <input type="number" name="max_price" class="form-control form-control-sm"
                   placeholder="Max $" min="0" step="0.01" value="{{ request('max_price') }}">
          </div>

          <!-- Sort -->
          <div class="me-2 mb-2">
            <select name="sort" class="form-control form-control-sm">
              <option value="">Sort By</option>
              <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
              <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
              <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price ↑</option>
              <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price ↓</option>
            </select>
          </div>

          <!-- Submit -->
          <div class="mb-2">
            <button type="submit" class="btn btn-sm btn-primary">
              <i class="fas fa-filter"></i>
            </button>
          </div>

        </div>
      </form>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        @forelse($products as $product)
          <div class="col-6 col-sm-4 col-md-3 mb-4">
            <div class="card card-hover h-100 shadow-sm position-relative">
              <!-- Wishlist Button -->
              <form action="{{ route('wishlist.add', $product->id) }}" method="POST"
                    class="position-absolute" style="top: 10px; right: 10px; z-index: 2;">
                @csrf
                <button type="submit" class="btn btn-sm btn-light text-danger border-0">
                  <i class="far fa-heart"></i>
                </button>
              </form>

              <!-- Product Image -->
              <div class="card-img-top overflow-hidden" style="height:180px;">
                <img src="{{ Storage::url($product->image) }}"
                     alt="{{ $product->name }}"
                     class="w-100"
                     style="object-fit: cover; height: 100%;" />
              </div>

              <div class="card-body d-flex flex-column">
                <h6 class="card-title">{{ Str::limit($product->name, 30) }}</h6>
                <p class="text-muted flex-grow-1 small">
                  {{ Str::limit($product->description, 60) }}
                </p>

                <div class="mt-auto d-flex justify-content-between align-items-center">
                  {{-- Discounted Price Logic --}}
                  @if($product->sale && $product->sale->isActive())
                    <div>
                      <span class="font-weight-bold text-danger">
                        ${{ number_format($product->discounted_price, 2) }}
                      </span>
                      <small class="text-muted"><s>
                        ${{ number_format($product->price, 2) }}
                      </s></small>
                    </div>
                  @else
                    <span class="font-weight-bold text-primary">
                      ${{ number_format($product->price, 2) }}
                    </span>
                  @endif

                  {{-- Add to Cart --}}
                  <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success">
                      <i class="fas fa-cart-plus"></i>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <div class="alert alert-warning text-center">
              No products found.
            </div>
          </div>
        @endforelse
      </div>

      @if(method_exists($products, 'links'))
        <div class="d-flex justify-content-center">
          {{ $products->appends(request()->input())->links() }}
        </div>
      @endif
    </div>
  </section>
</div>

<!-- Floating Cart Button -->
<a href="{{ route('cart.view') }}"
   class="btn btn-info btn-lg rounded-circle shadow position-fixed d-flex align-items-center justify-content-center"
   style="bottom:20px; right:20px; width:60px; height:60px;">
  {{-- White cart icon --}}
  <i class="fas fa-shopping-cart fa-lg text-white"></i>

  @auth
    @php
      $count = Auth::user()->cart?->items->sum('quantity') ?? 0;
    @endphp
    @if($count)
      {{-- Red badge with white text and solid background --}}
      <span class="badge badge-pill position-absolute"
            style="top:-6px; right:-6px; font-size:0.75rem; background-color:red; color:white;">
        {{ $count }}
      </span>
    @endif
  @endauth
</a>
@endsection