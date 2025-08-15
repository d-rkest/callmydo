@extends('layouts.app')

@section('title', 'View Appointment')
@section('navbar-title', 'View Appointment')

@section('sidebar-menu')
    @component('components.doctor-menu') @endcomponent
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('doctor.dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <a href="{{ route('schedule.index') }}" class="text-blue-600 hover:text-blue-800">Schedule</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">View Appointment</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">View Appointment</h2>

    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Appointment Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <p><strong>Date:</strong> {{ $appointment->appointment_date }}</p>
            <p><strong>Time:</strong> {{ $appointment->appointment_time }} WAT</p>
            <p><strong>Patient:</strong> {{ $appointment->user->name }}</p>
            <p><strong>Reason:</strong> {{ $appointment->reason ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow mt-6">
        <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">User Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h4 class="text-md font-medium text-gray-700">Personal Details</h4>
                <p><strong>Name:</strong> {{ $appointment->user->name }}</p>
                <p><strong>Email:</strong> {{ $appointment->user->email }}</p>
                <p><strong>Phone:</strong> {{ $appointment->user->userDetail->phone ?? 'N/A' }}</p>
                <p><strong>Gender:</strong> {{ $appointment->user->userDetail->gender ?? 'N/A' }}</p>
                <p><strong>Address:</strong> {{ $appointment->user->userDetail->address ?? 'N/A' }}</p>
            </div>
            <div>
                <h4 class="text-md font-medium text-gray-700">Medical Information</h4>
                <p><strong>Height:</strong> {{ $appointment->user->medicalInformation->height ?? 'N/A' }}</p>
                <p><strong>Blood Group:</strong> {{ $appointment->user->medicalInformation->blood_group ?? 'N/A' }}</p>
                <p><strong>Genotype:</strong> {{ $appointment->user->medicalInformation->genotype ?? 'N/A' }}</p>
                <p><strong>Allergies:</strong> {{ $appointment->user->medicalInformation->known_allergies ?? 'N/A' }}</p>
                <p><strong>Health Issues:</strong> {{ $appointment->user->medicalInformation->health_issues ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class="md:ml-64 lg:ml-0 mt-6">
        @if ($appointment->status === 'pending')
            <form action="{{ route('schedule.accept', $appointment->id) }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Accept Appointment</button>
            </form>
        @else
            <p class="text-gray-500">This appointment has already been {{ $appointment->status }}.</p>
        @endif
    </div>
@endsection