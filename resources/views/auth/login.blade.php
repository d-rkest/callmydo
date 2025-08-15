@extends('layouts.guest')

@section('title', 'Call My Doctor - Login')

@section('content')
    <section class="min-h-screen flex items-center justify-center relative pt-16 hero-background">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-center text-blue-900 mb-6">Login to Call My Doctor</h2>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" type="password" name="password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-4 flex items-center">
                        <input id="remember" type="checkbox" name="remember" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                    </div>

                    <!-- Forgot Password -->
                    <div class="mb-6 text-sm">
                        <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-800">Forgot your password?</a>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="w-full bg-green-600 text-white p-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Login
                        </button>
                    </div>
                </form>

                <!-- Register Link -->
                <p class="mt-4 text-center text-sm text-gray-600">
                    Don’t have an account? <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800">Register here</a>.
                </p>
            </div>
        </div>
    </section>
@endsection