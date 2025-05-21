<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') - E - Commerce App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

    {{-- Header --}}
    <header class="bg-dark text-white py-4 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="mb-0">E - commerce App</h1>
            <nav>
                {{-- Home  --}}
                <a href="{{ url('/') }}" class="text-white me-3 text-decoration-none">Home</a>

                @guest
                    {{-- Guests see only Login and Register --}}
                    <a href="{{ route('login') }}" class="text-white me-3 text-decoration-none">Login</a>
                    <a href="{{ route('register') }}" class="text-white me-3 text-decoration-none">Register</a>
                @else
                    {{-- Logged in users see Products, Orders, greeting, and Logout --}}
                    <!-- <a href="{{ url('/products') }}" class="text-white me-3 text-decoration-none">Products</a> -->
                    <!-- <a href="{{ url('/orders') }}" class="text-white me-3 text-decoration-none">Orders</a> -->
                    <a href="{{ url('/carts') }}" class="text-white me-3 text-decoration-none">Carts</a>
                    <span class="me-3">Hello, {{ auth()->user()->name }}</span>

                    <a href="{{ route('logout') }}" 
                       class="text-white text-decoration-none"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                       Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endguest
            </nav>
        </div>
    </header>

    {{-- Main content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <small>© {{ date('Y') }} My Laravel Shop. All rights reserved.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
