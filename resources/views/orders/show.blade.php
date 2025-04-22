@extends('layout')

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">Order #{{ $order->id }} Details</h3>
        <div class="card-tools">
          <a href="{{ route('orders.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Orders
          </a>
        </div>
      </div>

      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-6">
            <p><strong>User:</strong> {{ $order->user->name ?? 'Guest' }}</p>
            <p><strong>Status:</strong> <span class="badge badge-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'in_progress' ? 'info' : 'danger') }}">
              {{ ucfirst($order->status) }}
            </span></p>
            <p><strong>Total:</strong> ${{ $order->total }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method ?? 'cash on delivery') }}</p>
          </div>

          <div class="col-md-6">
            <h5>Shipping Address</h5>
            <p>{{ $order->shippingAddress->line1 ?? '' }}</p>
            <p>{{ $order->shippingAddress->line2 ?? '' }}</p>
            <p>{{ $order->shippingAddress->city ?? '' }}, {{ $order->shippingAddress->zip ?? '' }}</p>
            <p>{{ $order->shippingAddress->country ?? '' }}</p>
          </div>
        </div>

        <h5>Items</h5>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Product</th>
              <th>Qty</th>
              <th>Unit Price</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($order->orderItems as $item)
              <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ $item->price }}</td>
                <td>${{ $item->quantity * $item->price }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        @if ($order->status === 'pending')
          <div class="mt-4">
            <form action="{{ route('orders.accept', $order->id) }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-success">
                <i class="fas fa-check-circle"></i> Accept
              </button>
            </form>

            <form action="{{ route('orders.decline', $order->id) }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-danger">
                <i class="fas fa-times-circle"></i> Decline
              </button>
            </form>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection
