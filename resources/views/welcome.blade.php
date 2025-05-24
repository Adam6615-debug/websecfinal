@extends('layouts.master')
@section('title', 'Home')

@section('content')
<div class="row mt-4">
    <div class="col-md-6">
        <h1>Welcome to Our Website!</h1>
    </div>
    
</div>

<div class="card mt-4">
    <div class="card-header">Why Use Our Site?</div>
    <div class="card-body">
        <p>Our site provides quick and efficient tools to assist with everyday calculations, data management, and more. Whether you're learning math, managing products, or handling users, we have the right tools for you.</p>
        <p>Sign up to get started and access exclusive features!</p>
        @auth
            <a href="{{ route('profile') }}" class="btn btn-primary">Go to Profile</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-success">Login</a>
            <a href="{{ route('register') }}" class="btn btn-warning">Register</a>
        @endauth
    </div>
</div>
@endsection
