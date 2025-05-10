@extends('layout')

@section('title', 'Products')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-box-open text-primary"></i> Product List</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
      <i class="fas fa-plus-circle"></i> Add Product
    </a>
  </div>
@stop

@section('content')

<div class="card shadow-sm">
  <div class="card-header bg-primary text-white">
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center w-100">

    <!-- Title -->
    <h3 class="card-title mb-2 mb-md-0">
      <i class="fas fa-box me-2"></i> All Products
    </h3>

    <!-- Search form -->
    <form action="{{ route('products.index') }}" method="GET" class="d-flex align-items-center" style="max-width: 300px;">
      <input type="text" name="search" class="form-control form-control-sm me-2" 
             placeholder="Search products..." value="{{ request('search') }}">
      <button type="submit" class="btn btn-light btn-sm">
        <i class="fas fa-search"></i>
      </button>
    </form>

  </div>
</div>

  <div class="card-body p-0">
    <div class="table-responsive">
        
      <table class="table table-striped table-hover mb-0">
        <thead class="thead-light">
  <tr>
    <th>
      <a href="{{ route('products.index', ['sort_by' => 'id', 'sort_direction' => $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
        #
        @if ($sortBy == 'id') 
          <i class="fas fa-sort{{ $sortDirection == 'asc' ? '-up' : '-down' }}"></i>
        @endif
      </a>
    </th>
    <th>
      <a href="{{ route('products.index', ['sort_by' => 'image', 'sort_direction' => $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
        Image
        @if ($sortBy == 'image') 
          <i class="fas fa-sort{{ $sortDirection == 'asc' ? '-up' : '-down' }}"></i>
        @endif
      </a>
    </th>
    <th>
      <a href="{{ route('products.index', ['sort_by' => 'name', 'sort_direction' => $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
        Name
        @if ($sortBy == 'name') 
          <i class="fas fa-sort{{ $sortDirection == 'asc' ? '-up' : '-down' }}"></i>
        @endif
      </a>
    </th>
    <th>
      <a href="{{ route('products.index', ['sort_by' => 'price', 'sort_direction' => $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
        Price
        @if ($sortBy == 'price') 
          <i class="fas fa-sort{{ $sortDirection == 'asc' ? '-up' : '-down' }}"></i>
        @endif
      </a>
    </th>
    <th>
      <a href="{{ route('products.index', ['sort_by' => 'stock', 'sort_direction' => $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
        Stock
        @if ($sortBy == 'stock') 
          <i class="fas fa-sort{{ $sortDirection == 'asc' ? '-up' : '-down' }}"></i>
        @endif
      </a>
    </th>
    <th>
      Status
    </th>
    <th class="text-right">Actions</th>
  </tr>
</thead>

        <tbody>
          @forelse($products as $product)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
               @if($product->image)
  <img src="{{ asset('storage/' . $product->image) }}"
       alt="{{ $product->name }}"
       class="img-thumbnail"
       style="max-width: 70px; height: 70px; object-fit: cover;">
@else
  <span class="text-muted">No Image</span>
@endif
            </td>
            <td>{{ $product->name }}</td>
            <td>${{ number_format($product->price, 2) }}</td>
            <td>{{ $product->stock }}</td>
            <td>
              @if($product->stock > 0)
                <span class="badge bg-success">In Stock</span>
              @else
                <span class="badge bg-danger">Out of Stock</span>
              @endif
            </td>
            <td class="text-right">
              <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-info">
                <i class="fas fa-edit"></i>
              </a>
              <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center text-muted">No products found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@stop
