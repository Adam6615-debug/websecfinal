<nav class="navbar navbar-expand-sm sticky-top">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="./">Home</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products_list') }}">Products</a>
            </li>
            @can('show_users')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users') }}">Users</a>
                </li>
            @endcan
        </ul>

        <ul class="navbar-nav ms-auto">
            @auth
                <li class="nav-item nav-link">Credit: ${{ auth()->user()->credit }}</li>

                <!-- User Profile Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person-circle"></i>
                                Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('orders') }}"><i class="bi bi-cart-check"></i>
                                Orders</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('do_logout') }}"><i class="bi bi-box-arrow-right"></i>
                                Logout</a></li>
                    </ul>
                </li>

            @else
                <li class="nav-item {{ request()->is('login') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                </li>
                <li class="nav-item {{ request()->is('register') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('register') }}"><i class="bi bi-person-plus"></i> Register</a>
                </li>
            @endauth

            <!-- Dark Mode Toggle -->
            <li class="nav-item">
                <button id="darkModeToggle" class="btn btn-sm btn-outline-secondary ms-2">
                    <i class="bi bi-moon-stars-fill"></i> Dark Mode
                </button>
            </li>
        </ul>

    </div>
</nav>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<!-- At the end of the <body> section -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/scripts.js') }}"></script>

<!-- CSS (resources/css/styles.css) -->
<style>
/* Light mode (default) */
body {
    background-color: #ffffff;
    color: #333333;
    transition: all 0.3s ease;
}

.navbar {
    background-color: #f8f9fa;
}

.nav-link {
    color: #333333;
}

/* Dark mode */
body.dark-mode {
    background-color: #222222;
    color: #ffffff;
}

body.dark-mode .navbar {
    background-color: #333333;
}

body.dark-mode .nav-link {
    color: #ffffff !important;
}

body.dark-mode .dropdown-menu {
    background-color: #333333;
    border-color: #444444;
}

body.dark-mode .dropdown-item {
    color: #ffffff;
}

body.dark-mode .dropdown-item:hover {
    background-color: #444444;
}

body.dark-mode .btn-outline-secondary {
    color: #ffffff;
    border-color: #ffffff;
}

body.dark-mode .btn-outline-secondary:hover {
    background-color: #444444;
}

/* Ensure active states are visible in both modes */
.nav-item .active {
    font-weight: bold;
    color: #007bff !important;
}
</style>

<!-- JavaScript (resources/js/scripts.js) -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const darkModeToggle = document.getElementById('darkModeToggle');
    const darkModeIcon = darkModeToggle.querySelector('i');
    
    // Check for saved theme preference or system preference
    const savedTheme = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        document.body.classList.add('dark-mode');
        darkModeIcon.classList.remove('bi-moon-stars-fill');
        darkModeIcon.classList.add('bi-sun-fill');
        darkModeToggle.innerHTML = '<i class="bi bi-sun-fill"></i> Light Mode';
    }
    
    darkModeToggle.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        const isDarkMode = document.body.classList.contains('dark-mode');
        
        // Update button text and icon
        darkModeIcon.classList.toggle('bi-moon-stars-fill', !isDarkMode);
        darkModeIcon.classList.toggle('bi-sun-fill', isDarkMode);
        darkModeToggle.innerHTML = isDarkMode 
            ? '<i class="bi bi-sun-fill"></i> Light Mode'
            : '<i class="bi bi-moon-stars-fill"></i> Dark Mode';
        
        // Save preference
        localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
    });
});
</script>