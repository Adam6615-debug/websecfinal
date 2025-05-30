@extends('layouts.master')
@section('title', 'Jackets')

@section('content')
<div class="container py-5 text-white">
    <h2 class="mb-4 fw-bold text-uppercase border-bottom border-secondary pb-2">Jackets</h2>

    <div class="row g-4">
        @foreach($products as $product)
            <div class="col-md-4">
                <div class="card bg-black border border-secondary shadow-sm">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title text-white text-uppercase">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ $product->description }}</p>
                        <p class="fw-bold text-white">${{ $product->price }}</p>
                        <a href="{{ route('product_details', $product->id) }}" class="btn btn-outline-light w-100">View Product</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
