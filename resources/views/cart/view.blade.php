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
                      <tr>
                        <td class="align-middle">{{ $item->product->name }}</td>
                        <td class="align-middle text-center">
                          <form action="{{ route('cart.updateQuantity', $item->id) }}" method="POST" class="form-inline justify-content-center">
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
                        <td class="align-middle text-right">
                          @if($item->product->sale && $item->product->sale->isActive())
                            ${{ number_format($item->quantity * $item->product->discounted_price, 2) }}
                          @else
                            ${{ number_format($item->quantity * $item->product->price, 2) }}
                          @endif
                        </td>
                        <td class="align-middle text-center">
                          <form action="{{ route('cart.removeItem', $item->id) }}" method="POST">
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
                      <span class="float-right">
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
