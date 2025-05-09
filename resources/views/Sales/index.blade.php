@extends('layouts.app')
@section('header','Manage Sales')
@section('content')
  <a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">New Sale</a>
  <table class="table">
    <thead>
      <tr>
        <th>Product</th><th>Discount</th><th>Period</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($sales as $sale)
      <tr>
        <td>{{ $sale->product->name }}</td>
        <td>{{ $sale->discount_percent }}%</td>
        <td>
          {{ $sale->start_date ?: '—' }} 
          to 
          {{ $sale->end_date ?: '—' }}
        </td>
        <td>
          <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-warning">Edit</a>
          <form method="POST" action="{{ route('sales.destroy', $sale) }}" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{ $sales->links() }}
@endsection
