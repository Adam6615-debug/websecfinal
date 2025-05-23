<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">\
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Basic Website - @yield('title')</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    {{-- Dark mode CSS --}}
    <style>
        .dark-mode {
            background-color: #121212 !important;
            color: #e0e0e0 !important;
        }
        .dark-mode .card,
        .dark-mode .table,
        .dark-mode .form-control,
        .dark-mode .btn {
            background-color: #1e1e1e;
            color: #e0e0e0;
            border-color: #444;
        }
        .dark-mode .btn {
            background-color: #333;
        }
    </style>
</head>
<body id="appBody">
    @include('layouts.menu')

    {{-- Dark Mode Toggle --}}
    <div class="container d-flex justify-content-end mt-2">
        <button class="btn btn-outline-dark btn-sm" onclick="toggleDarkMode()">Toggle Dark Mode</button>
    </div>

    <div class="container">
        @yield('content')
    </div>

    {{-- Dark Mode Script --}}
    <script>
        function toggleDarkMode() {
            document.getElementById('appBody').classList.toggle('dark-mode');
        }
    </script>
</body>
</html>

<script>
    // Apply stored theme preference on page load
    document.addEventListener("DOMContentLoaded", function () {
        const isDark = localStorage.getItem('darkMode') === 'true';
        if (isDark) {
            document.getElementById('appBody').classList.add('dark-mode');
        }
    });

    // Toggle dark mode and store preference
    function toggleDarkMode() {
        const body = document.getElementById('appBody');
        const isDark = body.classList.toggle('dark-mode');
        localStorage.setItem('darkMode', isDark);
    }
</script>

