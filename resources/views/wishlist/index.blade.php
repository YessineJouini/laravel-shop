@extends('layouts.app')
@section('header','My Wishlist')
@section('content')
  @if($wishlistItems->isEmpty())
    <p>You haven’t added anything yet.</p>
  @else
    <div class="row">
      @foreach($wishlistItems as $item)
        <div class="col-md-3 mb-4">
          <div class="card">
            <img src="{{ asset('storage/' . $item->product->image) }}" class="card-img-top">
            <div class="card-body">
              <h5>{{ $item->product->name }}</h5>
              <p>${{ number_format($item->product->price, 2) }}</p>
              <form method="POST" action="{{ route('wishlist.remove', $item->product->id) }}">
                @csrf
                <button class="btn btn-danger btn-sm">Remove</button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
@endsection
