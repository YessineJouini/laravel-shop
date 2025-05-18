@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
<div class="content-wrapper">
  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <h1>Your Cart</h1>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Flash messages -->
      @foreach (['success','error'] as $msg)
        @if(session($msg))
          <div class="alert alert-{{ $msg }} alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session($msg) }}
          </div>
        @endif
      @endforeach

      <div class="row">
        <div class="col-12">
          <div class="card card-outline card-primary mb-4">

            <!-- Card Header -->
            <div class="card-header">
              <h3 class="card-title">Shopping Cart</h3>
            </div>

            <!-- Card Body -->
            <div class="card-body p-0">
              @if($cartItems->isEmpty())
                <p class="text-center py-4">Your cart is empty.</p>
              @else
                <table class="table table-hover table-valign-middle mb-0">
                  <thead class="thead-light">
                    <tr>
                      <th>Product</th>
                      <th class="text-center" style="width:120px;">Qty</th>
                      <th class="text-right" style="width:120px;">Price</th>
                      <th class="text-right" style="width:140px;">Subtotal</th>
                      <th class="text-center" style="width:100px;">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($cartItems as $item)
                      <tr data-item-id="{{ $item->id }}">
                        <td class="align-middle">{{ $item->product->name }}</td>
                        <td class="align-middle text-center">
                          <form class="cart-qty-form form-inline justify-content-center">
                            @csrf
                            <input type="number"
                                   name="quantity"
                                   value="{{ $item->quantity }}"
                                   class="form-control form-control-sm"
                                   min="1"
                                   style="width: 60px;"
                            >
                            <button type="submit" class="btn btn-sm btn-primary ml-2">Update</button>
                          </form>
                        </td>
                        <td class="align-middle text-right">
                          @if($item->product->sale && $item->product->sale->isActive())
                            <span class="text-danger">${{ number_format($item->product->discounted_price, 2) }}</span>
                            <small class="text-muted"><s>${{ number_format($item->product->price, 2) }}</s></small>
                          @else
                            ${{ number_format($item->product->price, 2) }}
                          @endif
                        </td>
                        <td class="align-middle text-right item-subtotal">
                          @if($item->product->sale && $item->product->sale->isActive())
                            ${{ number_format($item->quantity * $item->product->discounted_price, 2) }}
                          @else
                            ${{ number_format($item->quantity * $item->product->price, 2) }}
                          @endif
                        </td>
                        <td class="align-middle text-center">
                          <form class="cart-remove-form d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              @endif
            </div>

            <!-- Card Footer -->
            @if(! $cartItems->isEmpty())
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-6">
                    <h5 class="mb-0">Total:
                      <span id="cart-total" class="float-right">
                        ${{ number_format($cartItems->sum(fn($i) => $i->quantity * ($i->product->sale && $i->product->sale->isActive() ? $i->product->discounted_price : $i->product->price)), 2) }}
                      </span>
                    </h5>
                  </div>
                  <div class="col-sm-6 text-right">
                    <a href="{{ route('cart.checkout.form') }}" class="btn btn-success">
                      <i class="fas fa-check-circle"></i> Proceed to Checkout
                    </a>
                  </div>
                </div>
              </div>
            @endif

          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('submit', '.cart-qty-form', function(e) {
    e.preventDefault();
    let form = $(this);
    let input = form.find('input[name="quantity"]');
    let itemId = input.closest('tr').data('item-id');
    let qty = input.val();

    $.ajax({
        url: '/cart/item/' + itemId + '/update',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            quantity: qty
        },
        success: function(response) {
            if(response.success) {
                // Update subtotal
                form.closest('tr').find('.item-subtotal').text('$' + response.item_subtotal);
                // Update total
                $('#cart-total').text('$' + response.cart_total);
                // Update floating cart badge if present
                let badge = $('.fa-shopping-cart').siblings('.badge');
                if (badge.length) {
                    if (response.cart_count > 0) {
                        badge.text(response.cart_count);
                    } else {
                        badge.remove();
                    }
                }
            }
        },
        error: function() {
            alert('Could not update quantity.');
        }
    });
});

$(document).on('submit', '.cart-remove-form', function(e) {
    e.preventDefault();
    if (!confirm('Remove this item from cart?')) return;
    let form = $(this);
    let row = form.closest('tr');
    let itemId = row.data('item-id');

    $.ajax({
        url: '/cart/item/' + itemId,
        type: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if(response.success) {
                row.remove();
                // Update total
                $('#cart-total').text('$' + response.cart_total);
                // Update floating cart badge if present
                let badge = $('.fa-shopping-cart').siblings('.badge');
                if (badge.length) {
                    if (response.cart_count > 0) {
                        badge.text(response.cart_count);
                    } else {
                        badge.remove();
                    }
                }
                // If cart is empty, show empty message
                if ($('tbody tr').length === 0) {
                    $('.table').remove();
                    $('.card-body').html('<p class="text-center py-4">Your cart is empty.</p>');
                    $('.card-footer').remove();
                }
            }
        },
        error: function() {
            alert('Could not remove item.');
        }
    });
});
</script>
