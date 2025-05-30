<nav class="navbar navbar-expand-sm sticky-top" data-bs-theme="dark">
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
                @if(auth()->user()->hasRole('Customer'))
                    <li class="nav-item nav-link">Credit: ${{ auth()->user()->credit }}</li>
                @endif

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person-circle"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('orders') }}"><i class="bi bi-cart-check"></i> Orders</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('do_logout') }}"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
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
        </ul>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Side Menu -->
        <div class="col-md-2 bg-dark text-white py-4" style="min-height: 100vh;">
            <h5 class="text-center">Categories</h5>
            <ul class="nav flex-column mt-3">
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('category', ['type' => 'tshirts']) }}">T-SHIRTS</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('category', ['type' => 'pants']) }}">PANTS</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('category', ['type' => 'accessories']) }}">ACCESSORIES</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('category', ['type' => 'jackets']) }}">JACKETS</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 py-4">
            @yield('content')
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.documentElement.setAttribute('data-bs-theme', 'dark');
    document.body.style.backgroundColor = '#000000';
});
</script>
