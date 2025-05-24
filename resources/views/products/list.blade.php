@extends('layouts.master')
@section('title', 'Products')
@section('content')
<div class="container mt-4">
    <!-- Page Header -->
    <div class="row align-items-center mb-4">
        <div class="col-10">
            <h1 class="display-4">Products</h1>
        </div>
        <div class="col-2 text-end">
            @can('add_products')
                <a href="{{ route('products_edit') }}" class="btn btn-success btn-lg">Add Product</a>
            @endcan
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search Form -->
    <form method="GET" action="{{ route('products_list') }}">
        @csrf
        <div class="row g-3 mb-4">
            <div class="col-md-2">
                <input name="keywords" type="text" class="form-control" placeholder="Search Keywords" value="{{ request()->keywords }}" />
            </div>
            <div class="col-md-2">
                <input name="min_price" type="number" step="0.01" class="form-control" placeholder="Min Price" value="{{ request()->min_price }}" />
            </div>
            <div class="col-md-2">
                <input name="max_price" type="number" step="0.01" class="form-control" placeholder="Max Price" value="{{ request()->max_price }}" />
            </div>
            <div class="col-md-2">
                <select name="order_by" class="form-select">
                    <option value="" {{ request()->order_by == '' ? 'selected' : '' }} disabled>Order By</option>
                    <option value="name" {{ request()->order_by == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="price" {{ request()->order_by == 'price' ? 'selected' : '' }}>Price</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="order_direction" class="form-select">
                    <option value="" {{ request()->order_direction == '' ? 'selected' : '' }} disabled>Order Direction</option>
                    <option value="ASC" {{ request()->order_direction == 'ASC' ? 'selected' : '' }}>Ascending</option>
                    <option value="DESC" {{ request()->order_direction == 'DESC' ? 'selected' : '' }}>Descending</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
            <div class="col-md-1">
                <a href="{{ route('products_list') }}" class="btn btn-secondary w-100">Reset</a>
            </div>
        </div>
    </form>

    <!-- Search Results Info -->
    @if (request()->keywords)
        <div class="card mb-4">
            <div class="card-body">
                Search results for: <strong>{{ request()->keywords }}</strong>
            </div>
        </div>
    @endif

    <!-- Products List -->
    @forelse ($products as $product)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <div class="row">
                    <!-- Product Image -->
                    <div class="col-md-4">
                        <img src="{{ asset('images/' . $product->photo) }}" class="img-thumbnail w-100" alt="{{ $product->name }}" style="max-height: 200px; object-fit: cover;">
                    </div>
                    <!-- Product Details -->
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col-8">
                                <h3 class="card-title">{{ $product->name }}</h3>
                            </div>
                            <div class="col-4 text-end">
                                @can('edit_products')
                                    <a href="{{ route('products_edit', ['product' => $product->id]) }}">Edit</a>

                                @endcan
                                @can('delete_products')
                                    <a href="{{ route('products_delete', $product->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                @endcan
                            </div>
                        </div>
                        <table class="table table-striped">
                            <tr>
                                <th width="20%">Name</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th>Model</th>
                                <td>{{ $product->model }}</td>
                            </tr>
                            <tr>
                                <th>Code</th>
                                <td>{{ $product->code }}</td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>${{ number_format($product->price, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $product->description }}</td>
                            </tr>
                            <tr>
                                <th>Quantity</th>
                                <td>{{ $product->quantity }}</td>
                            </tr>
                        </table>
                        <div class="mt-3">
                            @if (auth()->user() && auth()->user()->hasRole('Customer'))
                                @if ($product->quantity > 0)
                                    @if (auth()->user()->credit >= $product->price)
                                        <a href="{{ route('products_purchase_details', $product->id) }}" class="btn btn-primary">Buy</a>
                                    @else
                                        <span class="text-danger">Insufficient credit</span>
                                    @endif
                                @else
                                    <button class="btn btn-danger" disabled>Out of Stock</button>
                                @endif
                                <!-- Refund Button (Visible to Customers Only) -->
                                @if (auth()->user()->purchases()->where('product_id', $product->id)->exists())
                                    <a href="{{ route('products_refunded', $product->id) }}" class="btn btn-warning ms-2">Request Refund</a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">Buy</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info" role="alert">
            No products found.
        </div>
    @endforelse
</div>
@endsection