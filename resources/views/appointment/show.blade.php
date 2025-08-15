@extends('layouts.app')

@section('title', 'Appointment Details')
@section('navbar-title', 'Appointment Details')

@section('sidebar-menu')
    @component('components.user-menu') @endcomponent
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <a href="{{ route('appointment.index') }}" class="text-blue-600 hover:text-blue-800">Appointments</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">Appointment Details</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Appointment Details</h2>

    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Appointment Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <p><strong>Date:</strong> {{ $appointment->appointment_date }}</p>
            <p><strong>Time:</strong> {{ $appointment->appointment_time }} WAT</p>
            <p><strong>Doctor:</strong> {{ $appointment->doctor->name ?? 'Not assigned yet' }}</p>
            <p><strong>Specialization:</strong> {{ $appointment->doctor->specialization ?? 'N/A' }}</p>
            <p><strong>Status:</strong> {{ $appointment->status }}</p>
            <p><strong>Reason:</strong> {{ $appointment->reason ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow mt-6">
        <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Notes from Doctor</h3>
        <div class="space-y-2">
            @if ($appointment->findings || $appointment->diagnosis || $appointment->recommendations)
                @if ($appointment->findings) <p><strong>Findings:</strong> {{ $appointment->findings }}</p> @endif
                @if ($appointment->diagnosis) <p><strong>Diagnosis:</strong> {{ $appointment->diagnosis }}</p> @endif
                @if ($appointment->recommendations) <p><strong>Recommendations:</strong> {{ $appointment->recommendations }}</p> @endif
            @else
                <p class="text-gray-500">No notes available yet.</p>
            @endif
        </div>
    </div>
@endsection