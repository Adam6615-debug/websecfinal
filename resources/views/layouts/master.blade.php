<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Opium Threads - @yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts (Montserrat) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Load Heartless Font for Logo */
        @font-face {
            font-family: 'Heartless';
            src: url('{{ asset('fonts/heartless.woff2') }}') format('woff2'),
                 url('{{ asset('fonts/heartless.woff') }}') format('woff');
            font-weight: normal;
            font-style: normal;
        }
        body {
            background-color: #0d0d0d;
            color: #d9d9d9;
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
        }
        /* Logo Styling */
        .logo {
            font-family: 'Heartless', sans-serif;
            font-size: 2.5rem;
            color: #000000; /* Black logo */
            text-transform: uppercase;
            letter-spacing: 0.2rem;
            text-shadow: 0 0 10px #000000;
            animation: glitch 2s linear infinite;
            text-align: center;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
        
        /* Navbar Styling */
        .navbar {
            background-color: #1a1a1a;
            border-bottom: 1px solid #b0b0b0;
            padding: 3rem 0 1rem 0; /* Extra padding for logo */
            position: relative;
        }
        .navbar-brand, .nav-link {
            color: #d9d9d9 !important;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
        }
        .nav-link:hover {
            color: #b0b0b0 !important;
            text-shadow: 0 0 5px #b0b0b0;
        }
        /* General Styling */
        .card,
        .table,
        .form-control,
        .btn {
            background-color: #1a1a1a;
            color: #d9d9d9;
            border-color: #333;
            font-family: 'Montserrat', sans-serif;
            font-weight: 400;
        }
        .btn {
            background-color: #b0b0b0;
            color: #0d0d0d;
            font-weight: 700;
            text-transform: uppercase;
            border: none;
            transition: all 0.3s;
        }
        .btn:hover {
            background-color: #8c8c8c; /* Darker silver */
            box-shadow: 0 0 10px #b0b0b0;
        }
        /* Headings */
        h1, h2, h3, h4, h5, h6, .card-header {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: #b0b0b0;
            text-transform: uppercase;
        }
        /* Container */
        .container {
            padding-top: 2rem;
        }
    </style>
</head>
<body>
    <!-- Navbar with Logo -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <div class="logo">OPIUM</div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                @include('layouts.menu')
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>