@extends('layouts.app')

@section('content')
<div class="container-fluid">

  <!-- Welcome Card -->
  <div class="card card-primary mb-4 shadow">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-user-circle mr-2"></i>Welcome, {{ $user->name }}</h3>
    </div>
  </div>

  <div class="row">

    <!-- Orders Column -->
    <div class="col-lg-8">
      <div class="card card-outline card-success mb-4">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-shopping-bag mr-2"></i>Your Orders</h3>
        </div>
        <div class="card-body p-0">
          @if($orders->isEmpty())
            <p class="text-center py-4">You have no orders yet.</p>
          @else
            <table class="table table-hover mb-0">
              <thead class="thead-light">
                <tr>
                  <th>#</th>
                  <th>Date</th>
                  <th>Total</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($orders as $order)
                  <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td>${{ number_format($order->total,2) }}</td>
                    <td>
                    <span class="badge 
                        {{ $order->status === 'pending' ? 'bg-warning' : '' }}
                        {{ $order->status === 'shipping_in_progress' ? 'bg-info' : '' }}
                        {{ $order->status === 'declined' ? 'bg-danger' : '' }}
                        {{ $order->status === 'delivered' ? 'bg-success' : '' }}
                        text-white">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>   
                    </td>
                    <td class="text-right">
                      <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i> View
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @endif
        </div>
      </div>
    </div>

    <!-- Addresses Column -->
    <div class="col-lg-4">
      <div class="card card-outline card-info shadow mb-4">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-map-marker-alt mr-2"></i>Shipping Addresses</h3>
        </div>
        <div class="card-body">
          @if($addresses->isEmpty())
            <p>No saved shipping addresses.</p>
          @endif

          @foreach($addresses as $addr)
            <div class="border p-3 mb-3">
              <p class="mb-1">{{ $addr->line1 }}<br>{{ $addr->line2 }}</p>
              <p class="mb-1">{{ $addr->city }}, {{ $addr->zip }}</p>
              <p class="mb-2">{{ $addr->country }}</p>
              <form action="{{ route('dashboard.address.delete', $addr) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
              </form>
            </div>
          @endforeach

          <!-- New / Edit Address Form -->
          <form action="{{ route('dashboard.address.save') }}" method="POST">
            @csrf
            <h5 class="mb-3">Add New Address</h5>
            <div class="form-group">
              <label>Address Line 1</label>
              <input type="text" name="line1" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Address Line 2</label>
              <input type="text" name="line2" class="form-control">
            </div>
            <div class="form-group">
              <label>City</label>
              <input type="text" name="city" class="form-control" required>
            </div>
            <div class="form-group">
              <label>ZIP Code</label>
              <input type="text" name="zip" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Country</label>
              <input type="text" name="country" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-info btn-block">
              <i class="fas fa-plus-circle"></i> Save Address
            </button>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
