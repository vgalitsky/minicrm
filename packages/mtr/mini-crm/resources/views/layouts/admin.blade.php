<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin')</title>
    @push('styles')
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        nav { 
            background: #333; color: #fff; padding: 10px 0; 
            a { color: #fff; text-decoration: none; margin: 0 15px; }
            .container { display: flex; gap: 20px; }
        }
        
        main {
            .container { margin-left: 220px; padding: 20px; }
        }
    </style>
    @endpush
    @stack('styles')
</head>
<body>
    <nav>
        <div class="container">
            <a href="{{ route('minicrm.admin.tickets.index') }}" >Tickets</a>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <footer>
        <p >&copy; {{ date('Y') }} Mini CRM</p>
    </footer>

    @stack('scripts')
</body>
</html>
