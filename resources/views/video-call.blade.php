@extends('layouts.app')

@section('title', 'Video Call')
@section('navbar-title', 'Video Call')

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
                <span class="text-gray-500">Video Call</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Video Call</h2>

    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Video Call Session</h3>
        <div id="video-container" class="h-96 bg-gray-200 flex items-center justify-center">
            <p class="text-gray-600">Video call interface will be integrated here. Use a service like WebRTC or Zoom API.</p>
        </div>
        <p><strong>Appointment:</strong> 2025-08-09, 10:00 AM WAT with Dr. Jane Smith</p>
        <button id="end-call" class="mt-4 bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">End Call</button>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const endCall = document.getElementById('end-call');
        if (endCall) {
            endCall.addEventListener('click', function() {
                if (confirm('Are you sure you want to end the call?')) {
                    window.location.href = '{{ route('appointment.review', 1) }}'; // Redirect to review for user
                }
            });
        }
    });
</script>