<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Call My Doctor - Your trusted healthcare platform for emergencies, consultations, and medical reports.">
    <meta name="keywords" content="healthcare, doctor, ambulance, medical, prescription">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Call My Doctor')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .hero-background {
            background-image: url('images/cover.jpg'); /* Replace with valid path or CDN */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .card-stack {
            position: relative;
            margin-left: -2rem; /* Adjust overlap */
        }
        .card-stack > a {
            position: relative;
            z-index: 10;
        }
        .card-stack > a:hover {
            z-index: 40;
            transform: scale(1.05);
        }
        @media (max-width: 640px) { /* Adjust for very small screens */
            .card-stack {
                margin-left: 0;
            }
        }
        .animate-broadcast {
            animation: broadcast 2s infinite;
        }
        .animate-vibrate {
            animation: vibrate 0.5s infinite alternate;
        }
        @keyframes broadcast {
            0% { box-shadow: 0 0 0 0 rgba(0, 128, 0, 0.4); }
            40% { box-shadow: 0 0 0 15px rgba(0, 128, 0, 0); }
            80% { box-shadow: 0 0 0 30px rgba(0, 128, 0, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 128, 0, 0); }
        }
        @keyframes vibrate {
            0% { transform: translateX(0); }
            25% { transform: translateX(2px); }
            50% { transform: translateX(-2px); }
            75% { transform: translateX(2px); }
            100% { transform: translateX(0); }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Navigation Bar -->
    <nav class="bg-blue-900 text-white shadow-md fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold">Call My Doctor</a>
                </div>
                <!-- Menu/Dropdown -->
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('store') }}" class="px-3 py-2 text-sm font-medium text-gray-300 hover:border-b-2 border-yellow-600 focus:outline-none focus:border-b-2" aria-label="Store">Pharmacy</a>
                    <a href="{{ route('medical-report') }}" class="px-3 py-2 text-sm font-medium text-gray-300 hover:border-b-2 border-yellow-600 focus:outline-none focus:border-b-2" aria-label="Upload Report">Upload Report</a>
                    <a href="{{ route('give-first-aid') }}" class="px-3 py-2 text-sm font-medium text-gray-300 hover:border-b-2 border-yellow-600 focus:outline-none focus:border-b-2" aria-label="Give First Aid">Give First Aid</a>
                </div>
                <!-- Dropdown for Small Screens -->
                <div class="md:hidden">
                    <div class="relative">
                        <button class="el-dropdown focus:outline-none" id="menu-button" type="button" aria-expanded="false" aria-label="Toggle menu">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </button>
                        <div class="el-dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-md shadow-lg z-50" id="menu-dropdown">
                            <a href="{{ route('store') }}" class="block px-4 py-2 hover:bg-blue-100 focus:outline-none" aria-label="Store">Pharmacy</a>
                            <a href="{{ route('medical-report') }}" class="block px-4 py-2 hover:bg-blue-100 focus:outline-none" aria-label="Upload Report">Upload Report</a>
                            <a href="{{ route('give-first-aid') }}" class="block px-4 py-2 hover:bg-blue-100 focus:outline-none" aria-label="Give First Aid">Give First Aid</a>
                            {{-- @guest
                                <a href="{{ route('login') }}" class="block px-4 py-2 hover:bg-blue-100 focus:outline-none" aria-label="Login">Login</a>
                                <a href="{{ route('register') }}" class="block px-4 py-2 hover:bg-blue-100 focus:outline-none" aria-label="Signup">Signup</a>
                            @endguest --}}
                        </div>
                    </div>
                </div>
                <!-- Auth Links -->
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="relative">
                            <button class="flex items-center space-x-2 focus:outline-none bg-white hover:bg-blue-100 rounded-full p-0.5 pr-5" onclick="toggleDropdown()" aria-label="Toggle profile menu">
                                <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->profile_photo_path ? Storage::url(auth()->user()->profile_photo_path) : asset('images/profile.jpg') }}" alt="Profile">
                                <span class="text-sm text-gray-500 font-bold">{{ Auth::user()->name }}</span>
                                <i class="fa fa-caret-down text-gray-500 font-bold"></i>
                            </button>
                            <div id="dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-md shadow-lg z-50">
                                @if (auth()->user()->role === 'doctor')
                                    <a href="{{ route('doctor.dashboard') }}" class="block px-4 py-2 hover:bg-blue-100 focus:outline-none" aria-label="Doctor Dashboard">Doctor Dashboard</a>                                    
                                @else
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-blue-100 focus:outline-none" aria-label="Dashboard">Dashboard</a>                                    
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-blue-100 focus:outline-none" aria-label="Logout">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-blue-200 focus:outline-none" aria-label="Login">Login</a>
                        <a href="{{ route('register') }}" class="hover:text-blue-200 focus:outline-none" aria-label="Signup">Signup</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="bg-gray-600 text-white py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2025 Call My Doctor. All rights reserved.</p>
        </div>
    </footer>

    <!-- Dropdown Toggle Scripts -->
    <script>
        function toggleDropdown() {
            document.getElementById('dropdown').classList.toggle('hidden');
        }
        document.addEventListener('click', function (event) {
            const dropdown = document.getElementById('dropdown');
            const button = event.target.closest('button');
            if (!button && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Toggle menu dropdown for small screens
        document.getElementById('menu-button').addEventListener('click', function() {
            document.getElementById('menu-dropdown').classList.toggle('hidden');
        });
        document.addEventListener('click', function (event) {
            const dropdown = document.getElementById('menu-dropdown');
            const button = event.target.closest('#menu-button');
            if (!button && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>