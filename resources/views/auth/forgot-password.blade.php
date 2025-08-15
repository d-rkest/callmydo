@extends('layouts.guest')

@section('title', 'Call My Doctor - Forgot Password')

@section('content')
    <section class="min-h-screen flex items-center justify-center relative pt-16 hero-background">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-center text-blue-900 mb-6">Forgot Password</h2>

                @if (session('status'))
                    <div class="mb-4 text-sm text-green-600 text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="w-full bg-green-600 text-white p-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Send Password Reset Link
                        </button>
                    </div>
                </form>

                <!-- Back to Login Link -->
                <p class="mt-4 text-center text-sm text-gray-600">
                    Remember your password? <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Login here</a>.
                </p>
            </div>
        </div>
    </section>
@endsection