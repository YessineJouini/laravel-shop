@extends('layouts.app') {{-- Or your preferred layout --}}

@section('content')
<div class="container">
    <div class="card card-primary shadow">
        <div class="card-header">
            <h3 class="card-title">Welcome, {{ $user->name }}</h3>
        </div>

        <div class="card-body">
            <h4 class="mb-4"><i class="fas fa-shopping-bag mr-2"></i>Your Orders</h4>

            @forelse ($orders as $order)
                <div class="card mb-4 border">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <strong>Order #{{ $order->id }}</strong>
                        <span class="badge bg-dark">
                            Total: ${{ number_format($order->total, 2) }}
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped table-bordered mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>
                                            <span class="badge badge-light text-dark">
                                                {{ $item->quantity }}
                                            </span>
                                        </td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle"></i> No orders found.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
