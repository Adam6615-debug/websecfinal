@extends('layouts.master')
@section('title', 'Purchase Details')
@section('content')
<div class="container mt-4">
    <h1 class="display-4 mb-4">Purchase Details</h1>

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

    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title">{{ $product->name }}</h3>
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
                    <th>Quantity Available</th>
                    <td>{{ $product->quantity }}</td>
                </tr>
            </table>
            <form method="POST" action="{{ route('products_buy', $product->id) }}">
                @csrf
                @if ($product->quantity > 0 && auth()->user()->credit >= $product->price)
                    <button type="submit" class="btn btn-primary">Confirm Purchase</button>
                @else
                    <button class="btn btn-danger" disabled>
                        {{ auth()->user()->credit < $product->price ? 'Insufficient Credit' : 'Out of Stock' }}
                    </button>
                @endif
                <a href="{{ route('products_list') }}" class="btn btn-secondary ms-2">Back to Products</a>
            </form>
        </div>
    </div>
</div>
@endsection