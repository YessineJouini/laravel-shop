@extends('layout')

@section('content')
<div class="container">
    <h1 class="page-title mb-4"><i class="fas fa-tags text-primary"></i> Categories</h1>
    
    <!-- Add Category Button -->
    <a href="{{ route('categories.create') }}" class="btn btn-lg btn-outline-primary mb-3">
        <i class="fas fa-plus-circle"></i> Add New Category
    </a>

    <!-- Categories Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td class="text-right">
                                <!-- Edit Button -->
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-pencil-alt"></i> Edit
                                </a>
                                <!-- Delete Button -->
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
