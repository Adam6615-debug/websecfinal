@extends('layouts.master')

@section('title', 'Add Employee')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-center">
        <div class="card m-4 col-md-8 col-lg-6">
            <div class="card-header text-center">
                <h4>Add New Employee</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('addemployee') }}" method="post">
                    {{ csrf_field() }}

                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        <strong>Error!</strong> {{$error}}
                    </div>
                    @endforeach

                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password" name="password" required>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password:</label>
                        <input type="password" class="form-control" placeholder="Confirm password" name="password_confirmation" required>
                    </div>

                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-primary w-100">Add Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
