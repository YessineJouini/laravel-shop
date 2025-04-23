@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">

    <div class="card-header bg-light position-relative">
  <h5 class="mb-0 d-flex align-items-center text-secondary">
    <i class="fas fa-receipt mr-2"></i> 
    Order #{{ $order->id }}
  </h5>

  <div class="position-absolute w-100 d-flex justify-content-center" style="top: 50%; transform: translateY(-50%);">
    <span class="badge px-4 py-2 font-weight-bold text-uppercase"
      style="
        background-color: {{ 
          $order->status === 'pending' ? '#ffc107' : 
          ($order->status === 'shipping_in_progress' ? '#17a2b8' : 
          ($order->status === 'declined' ? '#dc3545' : '#28a745')) 
        }};
        color: white;
        font-size: 0.85rem;
         ">
      {{ ucfirst(str_replace('_',' ', $order->status)) }}
    </span>
  </div>
</div>


        <div class="card-body">
          <p class="text-muted mb-2">
            <strong>Order Date:</strong> {{ $order->created_at->format('M d, Y h:ia') }}
          </p>

          <hr class="my-4">

          <h5 class="mb-3"><i class="fas fa-box mr-2"></i> Order Items</h5>
          <table class="table table-sm table-hover">
            <thead class="thead-light">
              <tr>
                <th>Product</th>
                <th class="text-center">Quantity</th>
                <th class="text-right">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($order->orderItems as $item)
                <tr>
                  <td>{{ $item->product->name }}</td>
                  <td class="text-center">{{ $item->quantity }}</td>
                  <td class="text-right">${{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>

          <hr class="my-4">

          <h5 class="mb-3"><i class="fas fa-map-marker-alt mr-2"></i> Shipping Address</h5>
          <div class="pl-2">
            <p class="mb-1">{{ $order->shippingAddress->line1 }}</p>
            @if($order->shippingAddress->line2)
              <p class="mb-1">{{ $order->shippingAddress->line2 }}</p>
            @endif
            <p class="mb-1">{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->zip }}</p>
            <p class="mb-0">{{ $order->shippingAddress->country }}</p>
          </div>

          <div class="text-right mt-5">
            <h4 class="mb-0">Total Paid:</h4>
            <div class="display-5 font-weight-bold mt-2 p-2 text-success d-inline-block rounded">
              ${{ number_format($order->total, 2) }}
            </div>
          </div>
        </div>

        <div class="card-footer text-right bg-light">
          <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
          </a>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
