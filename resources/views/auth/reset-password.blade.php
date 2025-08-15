@extends('layouts.guest')

@section('title', 'Call My Doctor - Reset Password')

@section('content')
    <section class="min-h-screen flex items-center justify-center relative pt-16 hero-background">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-center text-blue-900 mb-6">Reset Password</h2>

                @if (session('status'))
                    <div class="mb-4 text-sm text-green-600 text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <!-- Password -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <input type="hidden" name="email" value="{{ $request->email }}">

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input id="password" type="password" name="password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="w-full bg-green-600 text-white p-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Reset Password
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