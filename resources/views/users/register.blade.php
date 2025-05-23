@extends('layouts.master')

@section('title', 'Register')

@section('content')
<div class="d-flex justify-content-center align-items-center mt-5">
  <div class="card shadow col-sm-8 col-md-6">
    <div class="card-header bg-primary text-white text-center">
      <h4>Create a New Account</h4>
    </div>
    <div class="card-body">
      <form action="{{ route('do_register') }}" method="post">
        {{ csrf_field() }}

        {{-- Error Handling --}}
        @if($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="form-group mb-3">
          <label for="name" class="form-label">Name:</label>
          <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
        </div>

        <div class="form-group mb-3">
          <label for="email" class="form-label">Email:</label>
          <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
        </div>

        <div class="form-group mb-3">
          <label for="password" class="form-label">Password:</label>
          <input type="password" name="password" class="form-control" placeholder="Choose a password" required>
        </div>

        <div class="form-group mb-4">
          <label for="password_confirmation" class="form-label">Confirm Password:</label>
          <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat your password" required>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Register</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
