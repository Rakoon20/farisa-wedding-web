<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Farisa Wedding Organizer - @yield('title', 'Home')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        html {
            scroll-behavior: smooth;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Main Content -->
    <main class="min-h-screen pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    @stack('scripts')
</body>
</html>