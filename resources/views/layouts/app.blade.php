<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Magura')</title>
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
            <img src="{{ asset('MAGURA (1).png') }}" alt="Logo" class="h-10 w-auto">
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
                    <img src="{{ asset('MAGURA (1).png') }}" alt="Logo" class="h-12 w-auto">
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
            <img src="{{ asset('MAGURA (1).png') }}" alt="Logo" class="h-14 w-auto mb-8">
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
            if (!modal) { console.error('Modal not found:', modalId); return; }
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }

        function togglePw(inputId, btn) {
            const input = document.getElementById(inputId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            btn.querySelector('svg').innerHTML = isPassword
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
        }

        // Close modal when clicking outside — delegated so it works for modals included dynamically
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                e.target.classList.add('hidden');
                e.target.style.display = 'none';
            }
        });
    </script>
</body>
</html>