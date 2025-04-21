@extends('store.layout')

@section('title', 'Your Cart')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
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
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title">Shopping Cart</h3>
            </div>

            <div class="card-body p-0">
              @if($cartItems->isEmpty())
                <p class="text-center py-4">Your cart is empty.</p>
              @else
                <table class="table table-hover table-valign-middle mb-0">
                  <thead>
                    <tr>
                      <th>Product</th>
                      <th class="text-center">Qty</th>
                      <th class="text-right">Price</th>
                      <th class="text-right">Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($cartItems as $item)
                    <tr>
                      <td>{{ $item->product->name }}</td>
                      <td class="text-center">{{ $item->quantity }}</td>
                      <td class="text-right">${{ number_format($item->product->price,2) }}</td>
                      <td class="text-right">
                        ${{ number_format($item->quantity * $item->product->price, 2) }}
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              @endif
            </div>

            @if(! $cartItems->isEmpty())
            <div class="card-footer">
              <div class="row">
                <div class="col-sm-6">
                  <h5 class="m-0">Total:
                    <span class="float-right">
                      ${{ number_format($cartItems->sum(fn($i) => $i->quantity * $i->product->price), 2) }}
                    </span>
                  </h5>
                </div>
                <div class="col-sm-6 text-right">
                <a href="{{ route('cart.checkout.form') }}" class="btn btn-success">
                    Proceed to Checkout
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
