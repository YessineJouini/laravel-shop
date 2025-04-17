@extends('layout')
@section('content')
<div class="container">
    <h1 class="text-center mb-4">Welcome to the Admin Dashboard</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="list-group">
                
                <a href="{{ route('categories.index') }}" class="list-group-item list-group-item-action">
                    <div class="d-flex flex-column">
                        <h4>Categories</h4>
                        <p class="mb-0">Manage all categories in your store.</p>
                    </div>
                </a>
                
                
                <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action">
                    <div class="d-flex flex-column">
                        <h4>Products</h4>
                        <p class="mb-0">Manage all products in your store.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Overall container styling */
    .container {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    /* Heading style */
    h1 {
        color: #2c3e50;
        font-size: 2.5rem;
        margin-bottom: 30px;
        font-family: 'Arial', sans-serif;
        font-weight: 600;
        text-align: center;
    }
    
    /* Row styling */
    .row {
        display: flex;
        justify-content: center;
        margin: 0 -15px;
    }
    
    /* Column styling */
    .col-md-8 {
        width: 100%;
        max-width: 800px;
        padding: 0 15px;
    }
    
    /* List Group styling */
    .list-group {
        display: flex;
        flex-direction: column;
        padding-left: 0;
        margin-bottom: 0;
        border-radius: 0.25rem;
    }
    
    /* List Group Item style */
    .list-group-item {
        position: relative;
        display: block;
        padding: 20px;
        margin-bottom: 15px;
        background-color: rgba(119, 213, 253, 0.57);
        border: 1px solid #ddd;
        border-radius: 8px;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .list-group-item-action {
        width: 100%;
        text-align: left;
        cursor: pointer;
    }
    
    .list-group-item:hover {
        background-color: #007bff;
        border-color: #007bff;
        transform: translateY(-3px);
        color: white !important;
        text-decoration: none;
    }
    
    .list-group-item:hover h4,
    .list-group-item:hover p {
        color: white !important;
    }
    
    .list-group-item h4 {
        font-size: 1.25rem;
        font-weight: 500;
        margin-bottom: 10px;
        color: #34495e;
    }
    
    .list-group-item p {
        font-size: 1rem;
        color: #7f8c8d;
        margin-bottom: 0;
    }
    
    /* Util classes */
    .text-center {
        text-align: center;
    }
    
    .mb-4 {
        margin-bottom: 1.5rem;
    }
    
    .mb-0 {
        margin-bottom: 0 !important;
    }
    
    .d-flex {
        display: flex;
    }
    
    .flex-column {
        flex-direction: column;
    }
    
    /* Ensure these Bootstrap classes are defined if not already loaded */
    .justify-content-center {
        justify-content: center;
    }
</style>
@endsection