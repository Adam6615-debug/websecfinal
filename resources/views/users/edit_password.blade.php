@extends('layouts.master')

@section('title', 'Edit User')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-center">
        <div class="card m-4 col-md-8 col-lg-6">
            <div class="card-header text-center">
                <h4>Edit User Password</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('save_password', $user->id) }}" method="post">
                    {{ csrf_field() }}

                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        <strong>Error!</strong> {{$error}}
                    </div>
                    @endforeach

                    @if(!auth()->user()->hasPermissionTo('admin_users') || auth()->id() == $user->id)
                    <div class="form-group mb-3">
                        <label for="old_password" class="form-label">Old Password:</label>
                        <input type="password" class="form-control @error('old_password') is-invalid @enderror" placeholder="Enter old password" name="old_password" required>
                        @error('old_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    @endif

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">New Password:</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter new password" name="password" required>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password:</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm new password" name="password_confirmation" required>
                        @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
