@extends('layouts.master')
@section('title', 'Login')
@section('content')

<div class="container-fluid min-vh-100">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header text-center py-4">
                    <h3 class="font-weight my-2">Welcome Back</h3>
                    <p class="text-muted mb-0">Please sign in to continue</p>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('do_login') }}" method="post">
                        @csrf

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                            <label for="email">Email address</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg" type="submit">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center py-3">
                    <div class="small">
                        <a href="{{ route('password.request') }}" class="text-decoration-none">
                            <i class="fas fa-key me-1"></i>Forgot Password?
                        </a>
                    </div>
                </div>

                <div class="card-footer border-top-0">
                    <div class="text-center mb-3">
                        <span class="text-muted">Or continue with</span>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('google.login') }}" class="btn btn-outline-danger">
                            <i class="fab fa-google me-2"></i>Continue with Google
                        </a>
                        <a href="{{ route('redirectToFacebook') }}" class="btn btn-outline-primary">
                            <i class="fab fa-facebook-f me-2"></i>Continue with Facebook
                        </a>
                        <a href="{{ route('redirectToGitHub') }}" class="btn btn-outline-dark">
                            <i class="fab fa-github me-2"></i>Continue with GitHub
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
