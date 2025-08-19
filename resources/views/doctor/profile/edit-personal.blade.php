@extends('layouts.app')

@section('title', 'Edit Personal Details')
@section('navbar-title', 'Edit Personal Details')

@section('sidebar-menu')
    @component('components.doctor-menu') @endcomponent
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('doctor.dashboard') }}" class="text-blue-600 hover:text-blue-800">Doctor Dashboard</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <a href="{{ route('doctor.profile') }}" class="text-blue-600 hover:text-blue-800">My Profile</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">Edit Profile</span>
            </li>
        </ol>
    </nav>
    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Edit Personal Details</h2>
    <form action="{{ route('doctor.profile.update.personal') }}" method="POST" class="bg-white p-6 rounded-lg shadow">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500" disabled>
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone', $userDetail->phone) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
            </div>
            <div>
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                    <option value="Male" {{ old('gender', $userDetail->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $userDetail->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('gender', $userDetail->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <textarea id="address" name="address" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('address', $userDetail->address) }}</textarea>
            </div>
            <div>
                <label for="license_number" class="block text-sm font-medium text-gray-700">License Number</label>
                <input type="text" id="license_number" name="license_number" value="{{ old('license_number', $doctorDetail->license_number) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
            </div>
            <div>
                <label for="specialization" class="block text-sm font-medium text-gray-700">Specialization</label>
                <input type="text" id="specialization" name="specialization" value="{{ old('specialization', $doctorDetail->specialization) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
            </div>
        </div>
        <button type="submit" class="mt-4 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Save Changes</button>
    </form>
@endsection