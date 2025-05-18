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
            <h3 class="card-title mb-2 mb-md-0">
                <i class="fas fa-box me-2"></i> All Products
            </h3>

            <form action="{{ route('products.index') }}" method="GET" class="d-flex align-items-center" style="max-width: 300px;">
                <input type="text" name="search" class="form-control form-control-sm me-2" 
                    placeholder="Search products..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-light btn-sm" aria-label="Search products">
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
                        @php
                            $columns = [
                                'id' => '#',
                                'image' => 'Image',
                                'name' => 'Name',
                                'price' => 'Price',
                                'stock' => 'Stock',
                            ];
                        @endphp

                        @foreach ($columns as $colKey => $colName)
                        <th>
                            <a href="{{ route('products.index', array_merge(request()->except('page'), [
                                'sort_by' => $colKey,
                                'sort_direction' => ($sortBy === $colKey && $sortDirection === 'asc') ? 'desc' : 'asc',
                            ])) }}">
                                {!! $colName !!}
                                @if ($sortBy === $colKey)
                                    <i class="fas fa-sort{{ $sortDirection === 'asc' ? '-up' : '-down' }}"></i>
                                @endif
                            </a>
                        </th>
                        @endforeach
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
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
                        <td class="text-end">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-info" title="Edit product">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete product">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer d-flex justify-content-end">
        {{ $products->links() }}
    </div>
</div>
@stop
