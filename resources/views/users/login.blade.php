@extends('layouts.master')
@section('title', 'Login')
@section('content')

<div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
  <div class="card shadow-lg p-4 col-sm-8 col-md-6 col-lg-4">
    <h4 class="text-center mb-3">Login to Your Account</h4>
    
    <div class="card-body">
      <form action="{{ route('do_login') }}" method="post">
        {{ csrf_field() }}

        {{-- Show validation errors --}}
        @foreach($errors->all() as $error)
          <div class="alert alert-danger">
            <strong>Error:</strong> {{ $error }}
          </div>
        @endforeach

        <div class="form-group mb-3">
          <label for="email" class="form-label">Email:</label>
          <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
        </div>

        <div class="form-group mb-4">
          <label for="password" class="form-label">Password:</label>
          <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>

        <div class="d-grid mb-3">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>

        <hr>

        <div class="d-grid gap-2">
          <a href="{{ route('google.login') }}" class="btn btn-success">Login with Google</a>
          <a href="{{ route('redirectToFacebook') }}" class="btn btn-primary">Login with Facebook</a>
          <a href="{{ route('redirectToGitHub') }}" class="btn btn-dark">Login with GitHub</a>
        </div>

      </form>
    </div>
  </div>
</div>

@endsection
