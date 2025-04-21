@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Checkout</h2>

    <form action="{{ route('cart.checkout') }}" method="POST">
    @csrf
    <input type="text" name="line1" placeholder="Street Address" value="{{ old('line1', $shippingAddress->line1 ?? '') }}">
    <input type="text" name="line2" placeholder="Apt/Suite (optional)" value="{{ old('line2', $shippingAddress->line2 ?? '') }}">
    <input type="text" name="city" placeholder="City" value="{{ old('city', $shippingAddress->city ?? '') }}">
    <input type="text" name="zip" placeholder="Postal Code" value="{{ old('zip', $shippingAddress->zip ?? '') }}">
    <input type="text" name="country" placeholder="Country" value="{{ old('country', $shippingAddress->country ?? '') }}">
    <button type="submit">Proceed to Checkout</button>
</form>

</div>
@endsection
