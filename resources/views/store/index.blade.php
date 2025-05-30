@extends($layout)

@section('title', 'Store')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp

  <section class="content-header">
    <div class="container-fluid">
      <h1 class="mb-3">Product Catalog</h1>
    </div>
  </section>

<!-- Filter Bar -->
  <div class="card mb-4" style="border-color: #00c2ed;">
  <div class="card-header" style="background-color: #00c2ed; padding: .5rem 1rem;">
    <div class="d-flex align-items-center justify-content-between">
      <!-- Search -->
      <form method="GET" action="{{ route('store.index') }}" class="input-group input-group-sm w-75">
        <span class="input-group-text bg-white border-0">
          <i class="fas fa-search" style="color: #00c2ed;"></i>
        </span>
        <input
          type="text"
          name="search"
          class="form-control form-control-sm border-0"
          placeholder="Search..."
          value="{{ request('search') }}"
        >
      </form>

      <!-- Toggle Filters -->
      <button
        class="btn btn-sm btn-light"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#filterOptions"
        aria-expanded="false"
        aria-controls="filterOptions"
      >
        <i class="fas fa-sliders-h" style="color: #00c2ed;"></i> Filters
      </button>
    </div>
  </div>

  <div class="collapse" id="filterOptions">
    <div class="card-body p-2">
      <form method="GET" action="{{ route('store.index') }}">
        <div class="d-flex flex-wrap align-items-center">
          <!-- Category -->
          <div class="me-2 mb-2 flex-fill" style="min-width: 120px;">
            <select name="category" class="form-control form-control-sm">
              <option value="">All Categories</option>
              @foreach($categories as $cat)
                <option
                  value="{{ $cat->id }}"
                  {{ request('category') == $cat->id ? 'selected' : '' }}
                >
                  {{ $cat->name }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Min Price -->
          <div class="me-2 mb-2" style="width: 100px;">
            <input
              type="number"
              name="min_price"
              class="form-control form-control-sm"
              placeholder="Min $"
              min="0"
              step="0.01"
              value="{{ request('min_price') }}"
            >
          </div>

          <!-- Max Price -->
          <div class="me-2 mb-2" style="width: 100px;">
            <input
              type="number"
              name="max_price"
              class="form-control form-control-sm"
              placeholder="Max $"
              min="0"
              step="0.01"
              value="{{ request('max_price') }}"
            >
          </div>

          <!-- Sort -->
          <div class="me-2 mb-2 flex-fill" style="min-width: 140px;">
            <select name="sort" class="form-control form-control-sm">
              <option value="">Sort By</option>
              <option value="newest"     {{ request('sort')=='newest'? 'selected':'' }}>Newest</option>
              <option value="oldest"     {{ request('sort')=='oldest'? 'selected':'' }}>Oldest</option>
              <option value="price_low"  {{ request('sort')=='price_low'? 'selected':'' }}>Price ↑</option>
              <option value="price_high" {{ request('sort')=='price_high'? 'selected':'' }}>Price ↓</option>
            </select>
          </div>

          <!-- Apply Button -->
          <div class="mb-2">
            <button type="submit" class="btn btn-sm" style="background-color: #00c2ed; color: #fff;">
              Apply
            </button>
          </div>
        </div>
      </form>
    </div>
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

            
           <!-- Product Image with Link -->
<a href="{{ route('products.show', $product->id) }}" class="text-decoration-none">
  <div class="card-img-top overflow-hidden bg-white d-flex align-items-center justify-content-center" style="height: 180px; border-radius: 0.5rem;">
    <img src="{{ Storage::url($product->image) }}"
         alt="{{ $product->name }}"
         class="img-fluid"
         style="max-height: 100%; max-width: 100%; object-fit: contain; transition: transform 0.3s ease;">
  </div>
</a>


            <div class="card-body d-flex flex-column">
              <h6 class="card-title">{{ Str::limit($product->name, 30) }}</h6>
              <p class="text-muted flex-grow-1 small">
                {{ Str::limit($product->description, 60) }}
              </p>

              <!-- Average Rating -->
              @php
                $avg = round($product->reviews()->avg('rating') ?? 0, 1);
              @endphp
              <div class="mb-1">
                @for ($i = 1; $i <= 5; $i++)
                  @if($i <= $avg)
                    <i class="fas fa-star text-warning"></i>
                  @elseif($i - $avg < 1)
                    <i class="fas fa-star-half-alt text-warning"></i>
                  @else
                    <i class="far fa-star text-warning"></i>
                  @endif
                @endfor
                <small class="text-muted">({{ number_format($avg, 1) }})</small>
              </div>

              <div class="mt-auto d-flex justify-content-between align-items-center">
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
              </div>
              @if($product->stock < 10 && $product->stock > 0)
                <div class="mt-1">
                  <span class="badge bg-danger text-white" style="font-size: 0.75rem;">Few units left</span>
                </div>
              @endif
            </div>

            <!-- Add to Cart Button -->
                    <div class="position-absolute" style="bottom: 10px; right: 10px;">
              <button type="button"
                      class="btn btn-sm btn-success add-to-cart-btn"
                      data-product-id="{{ $product->id }}">
                  <i class="fas fa-cart-plus"></i>
              </button>
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('click', '.add-to-cart-btn', function(e) {
    e.preventDefault();
    let btn = $(this);
    let productId = btn.data('product-id');
    $.ajax({
        url: '/cart/' + productId + '/add',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            btn.removeClass('btn-success').addClass('btn-secondary').prop('disabled', true);
            btn.html('<i class="fas fa-check"></i>');
            // Update cart 
            let badge = $('.fa-shopping-cart').siblings('.badge');
            if (badge.length) {
                if (response.cart_count > 0) {
                    badge.text(response.cart_count);
                } else {
                    badge.remove();
                }
            } else if (response.cart_count > 0) {
                
                $('.fa-shopping-cart').parent().append(
                    '<span class="badge badge-pill position-absolute" style="top:-6px; right:-6px; font-size:0.75rem; background-color:red; color:white;">' +
                    response.cart_count +
                    '</span>'
                );
            }
            //  alert
        },
        error: function(xhr) {
            alert('Could not add to cart. Please login or try again.');
        }
    });
});
</script>

@endsection
