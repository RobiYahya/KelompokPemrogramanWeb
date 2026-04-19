<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SIGURA')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-100">
    <div class="flex">
        <!-- Mobile Header -->
        <div class="lg:hidden fixed top-0 left-0 right-0 bg-purple-600 p-4 z-50 flex items-center justify-between">
            <h1 class="text-xl font-bold text-white">SIGURA</h1>
            <button onclick="toggleSidebar()" class="text-white p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Sidebar -->
        <div id="mobileSidebar" class="fixed inset-0 z-50 hidden lg:hidden">
            <div class="absolute inset-0 bg-black bg-opacity-50" onclick="toggleSidebar()"></div>
            <div class="absolute left-0 top-0 bottom-0 w-64 bg-purple-600 p-6 transform transition-transform">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-2xl font-bold text-white">SIGURA</h1>
                    <button onclick="toggleSidebar()" class="text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                @include('components.sidebar')
            </div>
        </div>

        <!-- Desktop Sidebar -->
        <div class="hidden lg:block w-64 bg-purple-600 min-h-screen p-6">
            <h1 class="text-2xl font-bold text-white mb-8">SIGURA</h1>
            @include('components.sidebar')
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 lg:p-8 pt-20 lg:pt-8">
            @yield('content')
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            sidebar.classList.toggle('hidden');
        }

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('hidden');
        }

        // Close modal when clicking outside
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
