@extends('layouts.app')

@section('title', 'Settings')
@section('navbar-title', 'Settings')

@section('sidebar-menu')
    @if (Auth::user()->role == 'doctor')
        @component('components.doctor-menu') @endcomponent        
    @else
        @component('components.user-menu') @endcomponent
    @endif
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">Settings</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Account Settings</h2>

    <div class="md:ml-64 lg:ml-0 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Update Password -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Update Password</h3>
            <form action="{{ route('settings.update-password') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                    <input type="password" id="current_password" name="current_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    @error('current_password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" id="new_password" name="new_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    @error('new_password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    @error('confirm_password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Update Password</button>
            </form>
        </div>

        <!-- Verify Email -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Verify Email</h3>
            <p class="text-sm text-gray-600 mb-4">Your email is currently <strong>user@example.com</strong>. Please verify it.</p>
            <form action="{{ route('settings.verify-email') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email_verification_code" class="block text-sm font-medium text-gray-700">Verification Code</label>
                    <input type="text" id="email_verification_code" name="email_verification_code" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    @error('email_verification_code')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Verify Email</button>
                <a href="{{ route('settings.resend-verification') }}" class="text-sm text-blue-600 hover:text-blue-800">Resend Verification Code</a>
            </form>
        </div>

        <!-- Update Phone -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Update Phone Number</h3>
            <form action="{{ route('settings.update-phone') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">New Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update Phone</button>
            </form>
        </div>

        <!-- Delete Account -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Delete Account</h3>
            <p class="text-sm text-gray-600 mb-4">Warning: This action is irreversible and will delete all your data.</p>
            <form action="{{ route('settings.delete-account') }}" method="POST" class="space-y-4">
                @csrf
                @method('DELETE')
                <div>
                    <label for="confirm_delete" class="block text-sm font-medium text-gray-700">Type "DELETE" to confirm</label>
                    <input type="text" id="confirm_delete" name="confirm_delete" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">Delete Account</button>
            </form>
        </div>
    </div>
@endsection