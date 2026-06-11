<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fashion Inspiration Library')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="app-shell">
        <header class="navbar">
            <a href="{{ route('garments.index') }}" class="brand">
                Fashion <span>Inspiration</span>
            </a>

            <nav class="nav-links">
                <a class="nav-link" href="{{ route('garments.index') }}">Library</a>
                <a class="button" href="{{ route('garments.create') }}">Upload Image</a>
            </nav>
        </header>

        <main class="container">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>