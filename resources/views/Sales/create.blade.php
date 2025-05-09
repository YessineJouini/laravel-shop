@extends('layouts.app')
@section('header','New Sale')
@section('content')
  <form action="{{ route('sales.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label>Product</label>
      <select name="product_id" class="form-control">
        @foreach($products as $p)
          <option value="{{ $p->id }}">{{ $p->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="mb-3">
      <label>Discount %</label>
      <input type="number" name="discount_percent" class="form-control" min="1" max="100">
    </div>
    <div class="mb-3">
      <label>Start Date</label>
      <input type="date" name="start_date" class="form-control">
    </div>
    <div class="mb-3">
      <label>End Date</label>
      <input type="date" name="end_date" class="form-control">
    </div>
    <button class="btn btn-success">Save</button>
  </form>
@endsection
