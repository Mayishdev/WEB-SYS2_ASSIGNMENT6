<nav class="bg-gradient-to-r from-purple-600 to-blue-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo and Title -->
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-white font-bold text-xl flex items-center gap-2 hover:opacity-90 transition-opacity">
                    📊 Analytics Dashboard
                </a>
            </div>

            <!-- Center Navigation -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="text-white hover:text-gray-100 font-semibold transition-colors">
                    Sales Overview
                </a>
            </div>

            <!-- Right side info -->
            <div class="text-white text-sm font-medium">
                Real-time Sales Tracking
            </div>
        </div>
    </div>
</nav>
