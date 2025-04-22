@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Checkout</h1>

    <div class="card">
        <div class="card-body">
            <h4>Order Summary</h4>

            <h5>Items:</h5>
            <ul class="list-group">
                @foreach ($cartItems as $item)
                    <li class="list-group-item">
                        <strong>{{ $item->product->name }}</strong> 
                        x {{ $item->quantity }} 
                        = ${{ $item->quantity * $item->product->price }}
                    </li>
                @endforeach
            </ul>

            <p><strong>Total:</strong> ${{ $total }}</p>

            <h4>Shipping Address:</h4>
            @if ($shippingAddress)
                <p>{{ $shippingAddress->line1 }}</p>
                <p>{{ $shippingAddress->line2 ?? '' }}</p>
                <p>{{ $shippingAddress->city }}, {{ $shippingAddress->zip }}</p>
                <p>{{ $shippingAddress->country }}</p>
            @else
                <p>No shipping address available</p>
            @endif

            <h4>Select Payment Method:</h4>
            <form action="{{ route('order.confirmation') }}" method="POST">
                @csrf

                <!-- Payment method options -->
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="payment_cash" value="cash_on_delivery" checked>
                    <label class="form-check-label" for="payment_cash">
                        Cash on Delivery
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="payment_card" value="card">
                    <label class="form-check-label" for="payment_card">
                        Card Payment
                    </label>
                </div>

                <div id="card_details" class="mt-3" style="display: none;">
                    <h5>Enter Card Details</h5>
                    <div class="form-group">
                        <label for="card_number">Card Number</label>
                        <input type="text" class="form-control" id="card_number" name="card_number" maxlength="16" placeholder="Enter 16-digit card number" />
                    </div>
                    <div class="form-group">
                        <label for="expiry_date">Expiry Date</label>
                        <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY" />
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" maxlength="3" placeholder="Enter 3-digit CVV" />
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-3">Proceed to Payment</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Toggle card payment details based on selected payment method
    document.querySelectorAll('input[name="payment_method"]').forEach((input) => {
        input.addEventListener('change', function() {
            if (this.value === 'card') {
                document.getElementById('card_details').style.display = 'block';
            } else {
                document.getElementById('card_details').style.display = 'none';
            }
        });
    });
</script>

@endsection
