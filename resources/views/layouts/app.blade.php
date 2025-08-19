<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Call My Doctor - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        #sidebar {
            transition: transform 0.3s ease-in-out;
        }
        .active {
            background-color: #ffffff;
            color: rgb(47, 47, 47);
        }
        @media (max-width: 1023px) { /* sm: and md: screens */
            #sidebar {
                z-index: 60; /* Above main content */
            }
            main {
                width: 100% !important; /* Full width on sm/md */
                margin-left: 0 !important;
            }
        }
        .alert {
            opacity: 1;
            transition: opacity 0.5s ease-out;
        }
        .alert.fade-out {
            opacity: 0;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-blue-900 text-white transform" :class="{ '-translate-x-full': !isOpen }">
            <div class="flex items-center justify-between h-16 border-b border-blue-700 px-4">
                <a href="{{ route('welcome') }}" class="text-xl font-bold">Call My Doctor</a>
                <button id="close-sidebar" class="md:hidden text-white hover:text-gray-300 ">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="mt-5">
                @yield('sidebar-menu')
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <nav class="bg-blue-900 text-white p-4 flex justify-between items-center shadow-md w-full">
                <div class="flex items-center">
                    <button id="toggle-sidebar" class="md:hidden mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                    <span class="text-xl font-bold">@yield('navbar-title')</span>
                </div>
                <div class="relative">
                    <button id="profile-btn" class="flex items-center space-x-2 focus:outline-none bg-white hover:bg-blue-100 rounded-full p-0.5 pr-5">
                        <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->profile_photo_path ? Storage::url(auth()->user()->profile_photo_path) : asset('images/profile.jpg') }}" alt="Profile">
                        <span class="text-sm text-gray-500 font-bold">{{ Auth::user()->name }}</span>
                        <i class="fa fa-caret-down text-gray-600 font-bold"></i>
                    </button>
                    <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-md shadow-lg z-50">
                        @if (Auth::user()->role === 'doctor')
                            <a href="{{ route('doctor.profile') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                        @else
                            <a href="{{ route('profile') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                        @endif
                        <a href="{{ route('logout') }}" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
                    </div>
                </div>
            </nav>

            <!-- Alert Messages -->
            @if (session('success'))
                <div id="alert-success" class="alert fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md shadow-md z-50" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline ml-2">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any() || session('error'))
                <div id="alert-error" class="alert fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md shadow-md z-50" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline ml-2">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        @else
                            {{ session('error') }}
                        @endif
                    </span>
                </div>
            @endif

            <!-- Content Area -->
            <main class="flex-1 p-6 overflow-y-auto ml-64 md:ml-64 lg:ml-64">
                @yield('content')
            </main>

            <!-- FAB -->
            <div class="fixed bottom-6 right-6">
                <div class="relative">
                    <button id="fab-toggle" class="bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </button>
                    <div id="fab-dropdown" class="hidden absolute bottom-16 right-0 w-48 bg-white text-gray-800 rounded-md shadow-lg z-50">
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">New Appointment</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">New Report</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let isOpen = window.innerWidth > 768;

        // Sidebar Toggle
        document.getElementById('toggle-sidebar').addEventListener('click', function() {
            isOpen = !isOpen;
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.flex-1');
            sidebar.classList.toggle('-translate-x-full');
            mainContent.classList.toggle('ml-0');
        });

        // Close Sidebar
        document.getElementById('close-sidebar').addEventListener('click', function() {
            isOpen = false;
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.flex-1');
            sidebar.classList.add('-translate-x-full');
            mainContent.classList.add('ml-0');
        });

        // Profile Dropdown
        document.getElementById('profile-btn').addEventListener('click', function(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('profile-dropdown');
            dropdown.classList.toggle('hidden');
        });

        // Close profile dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profile-dropdown');
            if (!dropdown.contains(event.target) && event.target !== document.getElementById('profile-btn')) {
                dropdown.classList.add('hidden');
            }
        });

        // FAB Dropdown
        document.getElementById('fab-toggle').addEventListener('click', function(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('fab-dropdown');
            dropdown.classList.toggle('hidden');
        });

        // Close FAB dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('fab-dropdown');
            if (!dropdown.contains(event.target) && event.target !== document.getElementById('fab-toggle')) {
                dropdown.classList.add('hidden');
            }
        });

        // Handle menu item selection to close sidebar on sm/md
        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('click', function(event) {
                if (window.innerWidth <= 768) {
                    isOpen = false;
                    const sidebar = document.getElementById('sidebar');
                    const mainContent = document.querySelector('.flex-1');
                    sidebar.classList.add('-translate-x-full');
                    mainContent.classList.add('ml-0');
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            isOpen = window.innerWidth > 768;
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.flex-1');
            if (isOpen) {
                sidebar.classList.remove('-translate-x-full');
                mainContent.classList.remove('ml-0');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });

        // Fade out alert messages
        function fadeAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                setTimeout(() => {
                    alert.classList.add('fade-out');
                    setTimeout(() => alert.remove(), 500); // Remove after fade
                }, 3000); // Display for 3 seconds
            }
        }

        // Apply fade effect to success and error alerts
        document.addEventListener('DOMContentLoaded', function() {
            fadeAlert('alert-success');
            fadeAlert('alert-error');
        });
    </script>
</body>
</html>