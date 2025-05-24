@extends('layouts.master')
@section('title', 'Opium Threads')

@section('content')
<section class="opium-mode">
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-6">
                <h1 class="glitch">Welcome to Opium Threads!</h1>
                <p>Explore our exclusive streetwear collection:</p>
                <ul>
                    @can('show_users')
                        <li><a href="{{ route('users') }}">Manage Users</a></li>
                    @endcan
                </ul>
            </div>
        </div>
    </section>

    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <p>Opium Threads delivers raw, unfiltered streetwear that screams rebellion. Our designs are built for those who live loud and fearless. Join the movement.</p>
                <p>Sign up to unlock exclusive drops and features!</p>
                @auth
                    <a href="{{ route('profile') }}" class="btn btn-primary">Go to Profile</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-success">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-warning">Register</a>
                @endauth

        </div>
    </div>
@endsection