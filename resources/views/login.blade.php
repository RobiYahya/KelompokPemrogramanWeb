<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Warehouse Stock Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }
        .login-bg {
            background-color: #AD9AE1;
        }
        .login-illustration-bg {
            background-color: #EBE7FB;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8 login-bg">
    <div class="bg-white rounded-2xl shadow-2xl flex flex-col lg:flex-row overflow-hidden w-full max-w-5xl">
        <!-- Illustration Section -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-8 lg:p-12 relative overflow-hidden order-1 lg:order-2 login-illustration-bg">
            <div class="relative z-10 text-center">
                <img src="{{ asset('gambarlogin.png') }}" alt="Login Illustration" class="w-48 h-48 sm:w-64 sm:h-64 lg:w-80 lg:h-80 mx-auto object-contain max-w-full">
            </div>
        </div>

        <!-- Login Form Section -->
        <div class="w-full lg:w-1/2 p-6 sm:p-8 lg:p-12 flex flex-col justify-center order-2 lg:order-1">
            <div class="mb-2">
                <h1 class="text-xl sm:text-2xl lg:text-2xl font-semibold text-gray-800 mb-2 text-center lg:text-left">Login - Warehouse Stock Management System (MAGURA)</h1>
            </div>

            @if ($errors->any())
            <div class="alert alert-error">
                {{ $errors->first('id_pegawai') }}
            </div>
            @endif

            <form action="{{ route('login.authenticate') }}" method="POST" class="space-y-4 sm:space-y-6">
                @csrf

                <div class="form-group">
                    <label for="id_pegawai" class="form-label">Employee ID</label>
                    <input 
                        type="text" 
                        id="id_pegawai" 
                        name="id_pegawai" 
                        value="{{ old('id_pegawai') }}"
                        class="form-input"
                        placeholder="Enter Employee ID"
                        required
                        autocomplete="username"
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input"
                            placeholder="Enter password"
                            required
                            autocomplete="current-password"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword()"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 p-1"
                            aria-label="Toggle password visibility"
                        >
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-full shadow-lg hover:shadow-xl active:scale-95">
                    Login
                </button>

                <div class="mt-4 sm:mt-6 p-4 bg-purple-50 rounded-lg">
                    <p class="text-sm text-purple-800">
                        <strong>Login as Warehouse Admin?</strong><br>
                        Use Employee ID & password to login
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>
</body>
</html>