@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-8">

      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-check-circle mr-2"></i> Order Confirmation
          </h3>
        </div>

        <div class="card-body">
          <!-- Thank You Callout -->
          <div class="callout callout-info">
            <h5><i class="fas fa-smile"></i> Thank you, {{ auth()->user()->name }}!</h5>
            <p>Your order has been placed successfully and is now processing.</p>
          </div>

          <!-- Order Details -->
          <h5 class="mt-4"><i class="fas fa-receipt mr-1"></i> Order Details</h5>
          <table class="table table-bordered table-striped">
            <thead class="thead-light">
              <tr>
                <th>Product</th>
                <th class="text-center" style="width: 80px;">Qty</th>
                <th class="text-right" style="width: 120px;">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($order->orderItems as $item)
              <tr>
                <td>{{ $item->product->name }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">
                  ${{ number_format($item->quantity * $item->price, 2) }}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

          <!-- Shipping Address -->
          <h5 class="mt-4"><i class="fas fa-truck mr-1"></i> Shipping Address</h5>
          @if($shippingAddress)
          <address class="mb-3">
            {{ $shippingAddress->line1 }}<br>
            @if($shippingAddress->line2){{ $shippingAddress->line2 }}<br>@endif
            {{ $shippingAddress->city }}, {{ $shippingAddress->zip }}<br>
            {{ $shippingAddress->country }}
          </address>
          @else
          <p><em>No shipping address provided.</em></p>
          @endif

          <!-- Total -->
          <h5 class="mt-4">
            <i class="fas fa-dollar-sign mr-1"></i>
            Total Paid: 
            <span class="text-success">
              ${{ number_format($order->total, 2) }}
            </span>
          </h5>
        </div>

        <div class="card-footer text-right">
          <a href="{{ route('store.index') }}" class="btn btn-primary">
            <i class="fas fa-shopping-cart mr-1"></i> Continue Shopping
          </a>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
