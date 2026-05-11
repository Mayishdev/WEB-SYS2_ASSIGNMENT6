<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- Simple Header Navigation -->
            <nav class="bg-gradient-to-r from-purple-600 to-blue-600 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <a href="{{ route('dashboard') }}" class="text-white font-bold text-xl flex items-center gap-2">
                            📊 Analytics Dashboard
                        </a>
                        <div class="text-white text-sm">Sales Performance Tracker</div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow-sm border-b-4 border-purple-600">
                    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-gradient-to-r from-slate-800 to-slate-900 text-white mt-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div class="text-center">
                        <p class="text-sm">&copy; 2026 Sales Analytics Dashboard. All rights reserved.</p>
                        <p class="text-xs text-gray-400 mt-2">Powered by Laravel & Chart.js</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
