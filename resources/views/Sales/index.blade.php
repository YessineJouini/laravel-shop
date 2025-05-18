@extends('layout')

@section('header', 'Manage Sales')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h1 class="h3 text-primary mb-3 mb-md-0">
            <i class="fas fa-percentage me-2"></i> Manage Sales
        </h1>
        <a href="{{ route('sales.create') }}" class="btn btn-lg btn-outline-primary shadow-sm">
            <i class="fas fa-plus me-1"></i> New Sale
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Period</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $index => $sale)
                    <tr>
                        <td>{{ $sales->firstItem() + $index }}</td>
                        <td>{{ $sale->product->name }}</td>
                        <td>
                            <span class="badge bg-success">{{ $sale->discount_percent }}%</span>
                        </td>
                        <td>
                            <small>
                                {{ $sale->start_date ? date('M d, Y', strtotime($sale->start_date)) : '—' }} 
                                &mdash; 
                                {{ $sale->end_date ? date('M d, Y', strtotime($sale->end_date)) : '—' }}
                            </small>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-outline-warning me-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('sales.destroy', $sale) }}" class="d-inline" onsubmit="return confirm('Delete this sale?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fas fa-folder-open fa-lg mb-2 d-block"></i>
                            No sales found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-center">
                {{ $sales->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
