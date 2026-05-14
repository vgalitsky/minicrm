<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin')</title>
    <link
        rel="stylesheet"
        href="{{ asset('vendor/minicrm/admin/css/main.css') }}"
    >
    @stack('styles')
</head>
<body>
    <nav></nav>
    <main class="container">
        @yield('content')
    </main>

    <footer>
        <p >&copy; {{ date('Y') }} Mini CRM</p>
    </footer>

    @stack('scripts')
</body>
</html>
