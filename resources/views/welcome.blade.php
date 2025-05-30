@extends('layouts.master')
@section('title', 'Home')

@section('content')

{{-- Hero Video Section --}}
<section style="position: relative; height: 100vh; overflow: hidden;">
    <video autoplay muted loop playsinline
        style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
        <source src="{{ asset('videos/LOGOLoop.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    {{-- Optional Overlay Text --}}
    <div class="d-flex justify-content-center align-items-center h-100 text-white position-relative">
        <h1 class="display-4">OPIUM</h1>
    </div>
</section>

{{-- Main Content Section --}}
<section class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <h1>Welcome to Our Website!</h1>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">Welcome to OPIUM</div>
        <div class="card-body">
            <h4 class="mb-3">Discover Your Style</h4>
            <p class="text-muted mb-4">
                Experience luxury streetwear that defines modern fashion. OPIUM brings you exclusive designs that blend urban culture with high-end aesthetics.
            </p>

            @auth
                <a href="{{ route('profile') }}" class="btn btn-dark">View Profile</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-dark">Sign In</a>
                <a href="{{ route('register') }}" class="btn btn-outline-dark">Join OPIUM</a>
            @endauth
        </div>
    </div>
</section>

@endsection
