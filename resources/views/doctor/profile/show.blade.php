@extends('layouts.app')

@section('title', 'Doctor Profile')
@section('navbar-title', 'Profile')

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
                <span class="text-gray-500">My Profile</span>
            </li>
        </ol>
    </nav>
    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Doctor Profile</h2>

    <!-- Profile Photo and Personal Details Container -->
    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Profile Photo Card -->
            <div class="bg-gradient-to-br from-blue-100 to-white p-4 rounded-lg shadow-lg gap-5">
                <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Profile Photo</h3>
                <div class="flex flex-col items-center">
                    <img src="{{ Auth::user()->profile_photo_path ? Storage::url(auth()->user()->profile_photo_path) : url('images/profile.jpg') }}" alt="Profile Photo" class="w-32 h-32 rounded-full object-cover mb-2 border-4 border-blue-200">
                    <h3 class="m-1 font-bold text-gray-600">{{ Auth::user()->name }}</h3>
                    <p class="text-sm text-gray-600 mb-1">{{ auth()->user()->email ?? 'N/A' }}</p>
                    <form action="{{ route('doctor.profile.update.photo') }}" method="POST" enctype="multipart/form-data" class="text-center mt-2">
                        @csrf
                        <input type="file" name="profile_photo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                        <button type="submit" class="mt-2 bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700">Change Photo</button>
                    </form>
                </div>
                
                <h3 class="mt-5 text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Personal Details</h3>
                <div class="flex flex-col">
                    {{-- <p><strong>Name:</strong> {{ auth()->user()->name ?? 'N/A' }}</p> --}}
                    <p><strong>Phone:</strong> {{ auth()->user()->userDetail->phone ?? 'N/A' }}</p>
                    <p><strong>Gender:</strong> {{ auth()->user()->userDetail->gender ?? 'N/A' }}</p>
                    <p><strong>Address:</strong> {{ auth()->user()->userDetail->address ?? 'N/A' }}</p>
                    <p><strong>License Number:</strong> {{ auth()->user()->doctorDetail->license_number ?? 'N/A' }}</p>
                    <p><strong>Specialization:</strong> {{ auth()->user()->doctorDetail->specialization ?? 'N/A' }}</p>
                    <a href="{{ route('doctor.profile.edit.personal') }}" class="text-center mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Update</a>
                </div>
            </div>

            <!-- Availability Time Slot Card -->
            <div class="md:ml-64 lg:ml-0 bg-gradient-to-br from-green-100 to-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Availability Time Slot</h3>
                @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                    <div class="mb-4">
                        <h4 class="text-md font-medium text-gray-700">{{ $day }}</h4>
                        <form action="{{ route('doctor.profile.update.availability') }}" method="POST" class="flex items-center gap-2 mt-1">
                            @csrf
                            <input type="hidden" name="day" value="{{ $day }}">
                            <input type="time" name="start_time" value="{{ $availability[$day]->start_time ?? '' }}" class="border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                            <span>to</span>
                            <input type="time" name="end_time" value="{{ $availability[$day]->end_time ?? '' }}" class="border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                            <button type="submit" class="bg-green-600 text-white px-2 py-1 rounded-md hover:bg-green-700 text-sm">Save</button>
                            <button type="button" class="text-red-600 hover:text-red-800" onclick="this.parentElement.querySelector('input[name=start_time]').value = ''; this.parentElement.querySelector('input[name=end_time]').value = ''">Clear</button>
                        </form>
                    </div>
                @endforeach
            </div>
            <!-- Placeholder for Future Use -->
            <div class="hidden sm:block"></div>
        </div>
    </div>
@endsection

<script>
    // Simple client-side validation to ensure end time is after start time
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const startTime = form.querySelector('input[name=start_time]').value;
            const endTime = form.querySelector('input[name=end_time]').value;
            if (startTime && endTime && startTime >= endTime) {
                e.preventDefault();
                alert('End time must be after start time.');
            }
        });
    });
</script>