@extends('layouts.master')

@section('title', 'Main Page')

@section('content')
<section class="opium-mode">
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <h1 class="glitch">Welcome to Opium Threads!</h1>
                <p>Explore our exclusive streetwear collection:</p>
                
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">{{ $product->description }}</p>
                                    <p class="card-text"><strong>Price: ${{ $product->price }}</strong></p>
                                    
                                    @auth
                                        <a href="{{ route('purchase.details', $product->id) }}" class="btn btn-primary">Buy</a>
                                        <a href="{{ route('refund.request', $product->id) }}" class="btn btn-warning">Refund</a>
                                        
                                        @can('manage_products')
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-success">Edit</a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        @endcan
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-primary">Login to Buy</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @can('manage_products')
                    <div class="mt-4">
                        <a href="{{ route('products.create') }}" class="btn btn-success">Add New Product</a>
                    </div>
                @endcan
            </div>
        </div>
    </div>
</section>
@endsection