@extends('layouts.app')

@section('title', 'App Settings')
@section('navbar-title', 'App Settings')

@section('sidebar-menu')
    @component('components.admin-menu') @endcomponent
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">Admin Dashboard</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">App Settings</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">App Settings</h2>

    <!-- Settings Form -->
    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow">
        <form action="{{ route('admin.update-settings') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- General Settings -->
            <div class="border-b-2 border-gray-200 pb-6 mb-6">
                <h3 class="text-lg font-bold text-green-800 mb-4">General Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="app_name" class="block text-sm font-medium text-gray-700">App Name</label>
                        <input type="text" id="app_name" name="app_name" value="HealthCare Portal" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="timezone" class="block text-sm font-medium text-gray-700">Time Zone</label>
                        <select id="timezone" name="timezone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                            <option value="Africa/Lagos">Africa/Lagos (WAT)</option>
                            <option value="UTC">UTC</option>
                            <option value="America/New_York">America/New_York (EST)</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">A comprehensive healthcare management system.</textarea>
                    </div>
                </div>
            </div>

            <!-- Notification Settings -->
            <div class="border-b-2 border-gray-200 pb-6 mb-6">
                <h3 class="text-lg font-bold text-green-800 mb-4">Notification Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email Notifications</label>
                        <div class="mt-1 space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="notifications[email]" value="appointment_reminders" class="mr-2">
                                Appointment Reminders
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="notifications[email]" value="payment_updates" class="mr-2">
                                Payment Updates
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">SMS Notifications</label>
                        <div class="mt-1 space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="notifications[sms]" value="appointment_reminders" class="mr-2">
                                Appointment Reminders
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="notifications[sms]" value="payment_updates" class="mr-2">
                                Payment Updates
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="pb-6">
                <h3 class="text-lg font-bold text-green-800 mb-4">Security Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password_expiry" class="block text-sm font-medium text-gray-700">Password Expiry (Days)</label>
                        <input type="number" id="password_expiry" name="password_expiry" value="90" min="30" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="two_factor" class="block text-sm font-medium text-gray-700">Two-Factor Authentication</label>
                        <select id="two_factor" name="two_factor" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                            <option value="optional">Optional</option>
                            <option value="required">Required</option>
                            <option value="disabled">Disabled</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Save Settings</button>
            <a href="{{ route('admin.dashboard') }}" class="ml-4 text-blue-600 hover:text-blue-800">Cancel</a>
        </form>
    </div>
@endsection