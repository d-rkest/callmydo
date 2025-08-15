@extends('layouts.app')

@section('title', 'User Profile')
@section('navbar-title', 'Profile')

@section('sidebar-menu')
    @component('components.user-menu') @endcomponent
@endsection

@section('content')
    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">User Profile</h2>

    <!-- Profile Photo, Personal Details, and Next of Kin Container -->
    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <!-- Profile Photo Card -->
            <div class="bg-gradient-to-br from-blue-100 to-white p-4 rounded-lg shadow-lg">
                <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Profile Photo</h3>
                <div class="flex flex-col items-center">
                    <img src="{{ Auth::user()->profile_photo_path ? Storage::url(auth()->user()->profile_photo_path) : url('images/profile.jpg') }}" alt="Profile Photo" class="w-32 h-32 rounded-full object-cover mb-2 border-4 border-blue-200">
                    <p class="text-sm text-gray-600">{{ auth()->user()->email ?? 'N/A' }}</p>
                    <form action="{{ route('profile.update.photo') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                        @csrf
                        <input type="file" name="profile_photo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                        <button type="submit" class="mt-2 bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700">Upload</button>
                    </form>
                </div>
            </div>

            <!-- Personal Details Card -->
            <div class="bg-gradient-to-br from-green-100 to-white p-4 rounded-lg shadow-lg">
                <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Personal Details</h3>
                <p><strong>Name:</strong> {{ auth()->user()->name ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $userDetail->phone ?? 'N/A' }}</p>
                <p><strong>Gender:</strong> {{ $userDetail->gender ?? 'N/A' }}</p>
                <p><strong>Date of Birth:</strong> {{ $userDetail->date_of_birth ? $userDetail->date_of_birth : 'N/A' }}</p>
                <p><strong>Address:</strong> {{ $userDetail->address ?? 'N/A' }}</p>
                <a href="{{ route('profile.edit.personal') }}" class="mt-4 inline-block bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Update</a>
            </div>

            <!-- Next of Kin Card -->
            <div class="bg-gradient-to-br from-purple-100 to-white p-4 rounded-lg shadow-lg">
                <h3 class="text-lg font-bold text-purple-800 mb-2 border-b-2 border-purple-300 pb-1">Next of Kin</h3>
                <p><strong>Name:</strong> {{ $userDetail->next_of_kin_name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $userDetail->next_of_kin_email ?? 'N/Am' }}</p>
                <p><strong>Phone:</strong> {{ $userDetail->next_of_kin_phone ?? 'N/A' }}</p>
                <p><strong>Relationship:</strong> {{ $userDetail->next_of_kin_relationship ?? 'N/A' }}</p>
                <a href="{{ route('profile.edit.kin') }}" class="mt-4 inline-block bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">Update</a>
            </div>
        </div>
    </div>

    <!-- Medical Information Card -->
    <div class="md:ml-64 lg:ml-0 bg-gradient-to-br from-red-100 to-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-bold text-red-800 mb-2 border-b-2 border-red-300 pb-1">Medical Information</h3>
        <p><strong>Height:</strong> {{ $medicalInfo->height ?? 'N/A' }}</p>
        <p><strong>Blood Group:</strong> {{ $medicalInfo->blood_group ?? 'N/A' }}</p>
        <p><strong>Genotype:</strong> {{ $medicalInfo->genotype ?? 'N/A' }}</p>
        <p><strong>Known Allergies:</strong> {{ $medicalInfo->known_allergies ?? 'N/A' }}</p>
        <p><strong>Health Issues:</strong> {{ $medicalInfo->health_issues ?? 'N/A' }}</p>
        <a href="{{ route('profile.edit.medical') }}" class="mt-4 inline-block bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Update</a>
    </div>
@endsection