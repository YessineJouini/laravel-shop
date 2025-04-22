@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Order Confirmation</h2>

    <div class="order-summary">
        <h3>Thank you for your order, {{ auth()->user()->name }}!</h3>
        <p>Your order has been successfully placed and will be processed shortly.</p>

        <h4>Order Details:</h4>
        <ul>
            @foreach ($order->orderItems as $item)
                <li>{{ $item->product->name }} x {{ $item->quantity }} - ${{ $item->price * $item->quantity }}</li>
            @endforeach
        </ul>
        <h4>Shipping Address:</h4>
        @if($shippingAddress)
            <p>{{ $shippingAddress->line1 }}</p>
            <p>{{ $shippingAddress->line2 }}</p>
            <p>{{ $shippingAddress->city }}</p>
            <p>{{ $shippingAddress->zip }}</p>
            <p>{{ $shippingAddress->country }}</p>
        @else
            <p>No shipping address provided.</p>
        @endif

        <h4>Total: ${{ $order->total }}</h4>
    </div>

    <a href="{{ route('store.index') }}" class="btn btn-primary">Continue Shopping</a>
</div>
@endsection
