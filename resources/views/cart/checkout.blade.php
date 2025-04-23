@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">

        <!-- Cart Summary -->
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Your Cart</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($cartItems as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $item->product->name }} x {{ $item->quantity }}
                                <span>${{ $item->quantity * $item->product->price }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <h4 class="mt-3 text-right">Total: <strong>${{ $total }}</strong></h4>
                </div>
            </div>
        </div>

        <!-- Shipping & Payment Form -->
        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Shipping & Payment</h3>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('cart.checkout') }}" method="POST">
                        @csrf

                        <h5>Shipping Address</h5>
                        @if($addresses->count())
                        <div class="form-group">
                            <label for="saved_address">Select a Saved Address</label>
                            <select name="saved_address_id" id="saved_address" class="form-control">
                                <option value="">-- Enter New Address --</option>
                                @foreach ($addresses as $address)
                                    <option value="{{ $address->id }}">
                                        {{ $address->address_line }}, {{ $address->city }} - {{ $address->zip }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div id="new-address-fields">
                            <div class="form-group">
                                <label for="line1">Address Line 1</label>
                                <input type="text" class="form-control" id="line1" name="line1" value="{{ old('line1') }}">
                            </div>
                            <div class="form-group">
                                <label for="line2">Address Line 2</label>
                                <input type="text" class="form-control" id="line2" name="line2" value="{{ old('line2') }}">
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
                            </div>
                            <div class="form-group">
                                <label for="zip">ZIP Code</label>
                                <input type="text" class="form-control" id="zip" name="zip" value="{{ old('zip') }}">
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}">
                            </div>
                        </div>

                        <hr>
                        <h5>Payment Method</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="payment_cash" value="cash_on_delivery" checked>
                            <label class="form-check-label" for="payment_cash">Cash on Delivery</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="payment_card" value="card">
                            <label class="form-check-label" for="payment_card">Card Payment</label>
                        </div>

                        <!-- Card Payment Section -->
                        <div id="card_payment_form" class="mt-3" style="display: none;">
                            <h5>Card Details</h5>
                            <div class="form-group">
                                <label for="card_number">Card Number</label>
                                <input type="text" class="form-control" id="card_number" name="card_number" placeholder="Enter card number">
                            </div>
                            <div class="form-group">
                                <label for="card_expiry_date">Expiry Date (MM/YY)</label>
                                <input type="text" class="form-control" id="card_expiry_date" name="card_expiry_date" placeholder="MM/YY">
                            </div>
                            <div class="form-group">
                                <label for="card_cvc">CVC</label>
                                <input type="text" class="form-control" id="card_cvc" name="card_cvc" placeholder="CVC">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-block mt-3">Proceed Payment</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function toggleCardForm(paymentMethod) {
        const cardPaymentForm = document.getElementById('card_payment_form');
        const inputs = cardPaymentForm.querySelectorAll('input');

        if (paymentMethod === 'card') {
            cardPaymentForm.style.display = 'block';
            inputs.forEach(input => input.setAttribute('required', true));
        } else {
            cardPaymentForm.style.display = 'none';
            inputs.forEach(input => input.removeAttribute('required'));
        }
    }

    function toggleNewAddressFields() {
        const savedAddress = document.getElementById('saved_address');
        const newAddressFields = document.getElementById('new-address-fields');
        if (!savedAddress || savedAddress.value === '') {
            newAddressFields.style.display = 'block';
        } else {
            newAddressFields.style.display = 'none';
        }
    }

    document.querySelectorAll('input[name="payment_method"]').forEach(input => {
        input.addEventListener('change', e => toggleCardForm(e.target.value));
    });

    document.addEventListener('DOMContentLoaded', () => {
        toggleCardForm(document.querySelector('input[name="payment_method"]:checked').value);
        const savedAddressSelect = document.getElementById('saved_address');
        if (savedAddressSelect) {
            savedAddressSelect.addEventListener('change', toggleNewAddressFields);
            toggleNewAddressFields();
        }
    });
</script>
@endsection
