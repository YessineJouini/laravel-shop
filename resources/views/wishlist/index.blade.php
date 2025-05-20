@extends('layouts.app')
@section('header','My Wishlist')
@section('content')
  @if($wishlistItems->isEmpty())
    <div class="text-center py-5">
      <i class="fas fa-heart-broken fa-3x text-muted mb-3"></i>
      <p class="lead">You haven’t added anything yet.</p>
      <a href="{{ route('store.index') }}" class="btn btn-primary mt-2">Browse Products</a>
    </div>
  @else
    <div class="row">
      @foreach($wishlistItems as $item)
        <div class="col-md-3 mb-4">
          <div class="card h-100 shadow-sm">
            <img src="{{ asset('storage/' . $item->product->image) }}" class="card-img-top" style="height:180px;object-fit:cover;">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">{{ $item->product->name }}</h5>
              <p class="card-text mb-2">${{ number_format($item->product->price, 2) }}</p>
              <div class="mt-auto d-flex justify-content-between">
                <button class="btn btn-success btn-sm add-to-cart-btn"
                        data-product-id="{{ $item->product->id }}">
                  <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
                <button class="btn btn-outline-danger btn-sm remove-wishlist-btn"
                        data-product-id="{{ $item->product->id }}">
                  <i class="fas fa-trash"></i>
                </button>
                <a href="{{ route('products.show', $item->product->id) }}" class="btn btn-info btn-sm">
                    <i class="fas fa-eye"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('click', '.remove-wishlist-btn', function(e) {
    e.preventDefault();
    let btn = $(this);
    let productId = btn.data('product-id');
    $.ajax({
        url: '{{ url("/wishlist/remove") }}/' + productId,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            btn.closest('.col-md-3').fadeOut(300, function() {
                $(this).remove();
                if ($('.col-md-3').length === 0) {
                    location.reload();
                }
            });
        },
        error: function() {
            alert('Could not remove from wishlist.');
        }
    });
});

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
            btn.html('<i class="fas fa-check"></i> Added');
            
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
        },
        error: function() {
            alert('Could not add to cart.');
        }
    });
});
</script>
@endpush
