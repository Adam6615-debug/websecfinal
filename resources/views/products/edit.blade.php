@extends('layouts.master')

@section('title', 'Edit Product')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-center">
        <div class="card m-4 col-md-8 col-lg-6">
            <div class="card-header text-center">
                <h4>Edit Product</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('products_save', $product->id) }}" method="post">
                    {{ csrf_field() }}

                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        <strong>Error!</strong> {{$error}}
                    </div>
                    @endforeach

                    <div class="form-group mb-3">
                        <label for="code" class="form-label">Code:</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" placeholder="Code" name="code" required value="{{ $product->code }}">
                        @error('code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="model" class="form-label">Model:</label>
                        <input type="text" class="form-control @error('model') is-invalid @enderror" placeholder="Model" name="model" required value="{{ $product->model }}">
                        @error('model')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name" required value="{{ $product->name }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price:</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" placeholder="Price" name="price" required value="{{ $product->price }}">
                            @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="photo" class="form-label">Photo URL:</label>
                            <input type="text" class="form-control @error('photo') is-invalid @enderror" placeholder="Photo URL" name="photo" required value="{{ $product->photo }}">
                            @error('photo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" placeholder="Description" name="description" required>{{ $product->description }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" placeholder="Quantity" name="quantity" required value="{{ $product->quantity }}">
                        @error('quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
