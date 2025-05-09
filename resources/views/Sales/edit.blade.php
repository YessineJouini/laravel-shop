@extends('layouts.app')
@section('header','Edit Sale')
@section('content')
  <form action="{{ route('sales.update', $sale->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
      <label>Product</label>
      <select name="product_id" class="form-control">
        @foreach($products as $p)
          <option value="{{ $p->id }}" {{ $sale->product_id == $p->id ? 'selected' : '' }}>
            {{ $p->name }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="mb-3">
      <label>Discount %</label>
      <input type="number" name="discount_percent" class="form-control" min="1" max="100" value="{{ $sale->discount_percent }}">
    </div>
    <div class="mb-3">
      <label>Start Date</label>
      <input type="date" name="start_date" class="form-control" value="{{ $sale->start_date }}">
    </div>
    <div class="mb-3">
      <label>End Date</label>
      <input type="date" name="end_date" class="form-control" value="{{ $sale->end_date }}">
    </div>
    <button class="btn btn-primary">Update</button>
  </form>
@endsection