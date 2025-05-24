<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }
        .verify-box {
            margin-top: 80px;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 verify-box text-center">

            <h2 class="mb-4">🔐 Email Verification</h2>

            <p class="text-muted">
                We've sent a verification link to your email. Please check your inbox and click the link to verify your account.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success mt-4">
                    ✅ A new verification link has been sent to your email.
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-primary w-100">
                    Resend Verification Email
                </button>
            </form>

        </div>
    </div>

</body>
</html>
