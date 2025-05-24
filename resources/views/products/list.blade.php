@extends('layouts.master')
@section('title', 'Test Page')
@section('content')
<div class="row mt-2">
    <div class="col col-10">
        <h1>Products</h1>
    </div>

    <!-- Search and Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input name="keywords" type="text" class="form-control" placeholder="Search products..." value="{{ request()->keywords }}" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input name="min_price" type="number" class="form-control" placeholder="Min Price" value="{{ request()->min_price }}" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input name="max_price" type="number" class="form-control" placeholder="Max Price" value="{{ request()->max_price }}" />
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="order_by" class="form-select">
                        <option value="" {{ request()->order_by==""?"selected":"" }} disabled>Sort By</option>
                        <option value="name" {{ request()->order_by=="name"?"selected":"" }}>Name</option>
                        <option value="price" {{ request()->order_by=="price"?"selected":"" }}>Price</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="order_direction" class="form-select">
                        <option value="" {{ request()->order_direction==""?"selected":"" }} disabled>Order</option>
                        <option value="ASC" {{ request()->order_direction=="ASC"?"selected":"" }}>Ascending</option>
                        <option value="DESC" {{ request()->order_direction=="DESC"?"selected":"" }}>Descending</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Search Results Indicator -->
    @if(!empty(request()->keywords))
    <div class="alert alert-info mb-4">
        <i class="bi bi-info-circle"></i> Showing results for: <strong>{{ request()->keywords }}</strong>
    </div>
    @endif

    <!-- Products Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($products as $product)
        <div class="col">
            <div class="card h-100 shadow-sm product-card">
                <div class="position-relative">
                    <img src="{{asset("images/$product->photo")}}" class="card-img-top product-image" alt="{{$product->name}}">
                    @if($product->quantity <= 0)
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-danger">Out of Stock</span>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{$product->name}}</h5>
                    <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-primary mb-0">${{ number_format($product->price, 2) }}</h4>
                        <span class="badge bg-secondary">SKU: {{$product->code}}</span>
                    </div>

                    <div class="product-details mb-3">
                        <small class="text-muted">
                            <i class="bi bi-box"></i> Available: {{$product->quantity}} units<br>
                            <i class="bi bi-tag"></i> Model: {{$product->model}}
                        </small>
                    </div>
                    <div class="d-grid gap-2">
                        @if(auth()->user() && auth()->user()->hasRole('Customer'))
                            @if(auth()->user()->credit >= $product->price)
                                @if($product->quantity > 0)
                                <form method="POST" action="{{ route('products_buy', $product->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-cart-plus"></i> Add to Cart
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-secondary w-100" disabled>
                                    <i class="bi bi-x-circle"></i> Out of Stock
                                </button>
                                @endif
                            @else
                            <div class="alert alert-warning mb-0">
                                <i class="bi bi-exclamation-triangle"></i> Insufficient credit
                            </div>
                            @endif
                        @endif

                        @can('edit_products')
                        <a href="{{route('products_edit', $product->id)}}" class="btn btn-outline-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        @endcan

                        @can('delete_products')
                        <a href="{{route('products_delete', $product->id)}}" class="btn btn-outline-danger" 
                           onclick="return confirm('Are you sure you want to delete this product?')">
                            <i class="bi bi-trash"></i> Delete
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<form>
    <div class="row">
        <div class="col col-sm-2">
            <input name="keywords" type="text" class="form-control" placeholder="Search Keywords" value="{{ request()->keywords }}" />
        </div>
        <div class="col col-sm-2">
            <input name="min_price" type="numeric" class="form-control" placeholder="Min Price" value="{{ request()->min_price }}" />
        </div>
        <div class="col col-sm-2">
            <input name="max_price" type="numeric" class="form-control" placeholder="Max Price" value="{{ request()->max_price }}" />
        </div>
        <div class="col col-sm-2">
            <select name="order_by" class="form-select">
                <option value="" {{ request()->order_by==""?"selected":"" }} disabled>Order By</option>
                <option value="name" {{ request()->order_by=="name"?"selected":"" }}>Name</option>
                <option value="price" {{ request()->order_by=="price"?"selected":"" }}>Price</option>
            </select>
        </div>
        <div class="col col-sm-2">
            <select name="order_direction" class="form-select">
                <option value="" {{ request()->order_direction==""?"selected":"" }} disabled>Order Direction</option>
                <option value="ASC" {{ request()->order_direction=="ASC"?"selected":"" }}>ASC</option>
                <option value="DESC" {{ request()->order_direction=="DESC"?"selected":"" }}>DESC</option>
            </select>
        </div>
        <div class="col col-sm-1">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <div class="col col-sm-1">
            <button type="reset" class="btn btn-danger">Reset</button>
        </div>
    </div>
</form>

@foreach($products as $product)
<div class="card mt-2">
    <div class="card-body">
        <div class="row">
            <div class="col col-sm-12 col-lg-4">
                <img src="{{asset("images/$product->photo")}}" class="img-thumbnail" alt="{{$product->name}}" width="100%">
            </div>
            <div class="col col-sm-12 col-lg-8 mt-3">
                <div class="row mb-2">
                    <div class="col-8">
                        <h3>{{$product->name}}</h3>
                    </div>
                    <div class="col col-2">
                        @can('edit_products')
                        <a href="{{route('products_edit', $product->id)}}" class="btn btn-success form-control">Edit</a>
                        @endcan
                    </div>
                    <div class="col col-2">
                        @can('delete_products')
                        <a href="{{route('products_delete', $product->id)}}" class="btn btn-danger form-control">Delete</a>
                        @endcan
                    </div>

                </div>

                <table class="table table-striped">
                    <tr>
                        <th width="20%">Name</th>
                        <td>{{$product->name}}</td>
                    </tr>
                    <tr>
                        <th>Model</th>
                        <td>{{$product->model}}</td>
                    </tr>
                    <tr>
                        <th>Code</th>
                        <td>{{$product->code}}</td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>{{$product->price}}</td>
                    <tr>
                        <th>Description</th>
                        <td>{{$product->description}}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{$product->quantity}}</td>
                    </tr>
                    <div>
                        @if(auth()->user())
                        @if(auth()->user()->hasRole('Customer'))
                        @if(auth()->user()->credit >= $product->price)
                        <form method="POST" action="{{ route('products_buy', $product->id) }}">
                            @csrf
                            @if($product->quantity > 0)

                            <button type="submit" class="btn btn-primary mt-2">Buy</button>
                            @else
                            <button class="btn btn-danger" disabled>Out of Stock</button>
                            @endif
                        </form>
                        @else
                        <div class="text-danger mt-2">Insufficient credit</div>
                        @endif
                        @endif
                        @endif
                    </div>
                </table>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection