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
            @if (session('status'))
                <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
            @endif
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
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    @error('new_password_confirmation')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Update Password</button>
            </form>
        </div>

        <!-- Verify Email -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Verify Email</h3>
            <p class="text-sm text-gray-600 mb-4">Your email is currently <strong>{{ Auth::user()->email }}</strong>. @if (!Auth::user()->email_verified_at) Please verify it. @endif</p>
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-sm text-green-600">A new verification link has been sent to your email address.</div>
            @endif
            @if (!Auth::user()->email_verified_at)
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
                    <form action="{{ route('settings.resend-verification') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="text-sm text-blue-600 hover:text-blue-800">Resend Verification Code</button>
                    </form>
                </form>
            @else
                <p class="text-sm text-green-600">Your email is already verified.</p>
            @endif
        </div>

        <!-- Update Phone -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Update Phone Number</h3>
            @if (session('status'))
                <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
            @endif
            <form action="{{ route('settings.update-phone') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">New Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', Auth::user()->userDetail->phone ?? Auth::user()->doctorDetail->phone ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
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
            <form action="{{ route('settings.delete-account') }}" method="POST" id="deleteAccountForm" class="space-y-4">
                @csrf
                @method('DELETE')
                <div>
                    <label for="confirm_delete" class="block text-sm font-medium text-gray-700">Type "DELETE" to confirm</label>
                    <input type="text" id="confirm_delete" name="confirm_delete" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <button type="button" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" id="deleteAccountButton">Delete Account</button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md transform transition-all duration-300 scale-95 opacity-0 animate-fadeIn" style="animation-delay: 0.1s;">
            <h3 class="text-lg font-bold text-red-800 mb-4">Confirm Account Deletion</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to delete your account? This action will permanently delete all your data and cannot be reversed.</p>
            <div class="flex justify-end space-x-4">
                <button id="cancelDelete" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition duration-200">Cancel</button>
                <button id="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200">Delete Account</button>
            </div>
        </div>
    </div>

    <script>
        // Modal Animation
        function animateModal(action) {
            const modal = document.getElementById('deleteModal');
            const modalContent = modal.querySelector('div');
            if (action === 'show') {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 50);
            } else {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => modal.classList.add('hidden'), 300);
            }
        }

        // Delete Button Click Handler
        document.getElementById('deleteAccountButton').addEventListener('click', function() {
            animateModal('show');
        });

        // Cancel Button Handler
        document.getElementById('cancelDelete').addEventListener('click', function() {
            animateModal('hide');
        });

        // Confirm Delete Handler
        document.getElementById('confirmDelete').addEventListener('click', function() {
            document.getElementById('deleteAccountForm').submit();
        });

        // Fade-in Animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            .animate-fadeIn {
                animation: fadeIn 0.3s ease-out forwards;
            }
        `;
        document.head.appendChild(style);
    </script>
@endsection