<nav class="navbar navbar-expand-sm bg-light sticky-top">
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