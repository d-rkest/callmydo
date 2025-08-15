@extends('layouts.app')

@section('title', 'Video Call')
@section('navbar-title', 'Video Call')

@section('sidebar-menu')
    @if (auth()->user()->role === 'doctor')
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
        <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Join Video Call</h3>
        <div id="video-container" class="h-96 bg-gray-200 flex items-center justify-center">
            <div id="daily-call" style="width: 100%; height: 100%;"></div>
        </div>
        <p><strong>Appointment:</strong> {{ $appointment->appointment_date }}, {{ $appointment->appointment_time }} WAT with {{ $appointment->doctor->name ?? 'Not assigned yet' }}</p>
        <button id="end-call" class="mt-4 bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">End Call</button>
    </div>
@endsection

<script src="https://unpkg.com/@daily-co/daily-js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const callElement = document.getElementById('daily-call');
        const roomUrl = '{{ $roomUrl }}';

        // Check if Daily.js is loaded
        if (typeof window.DailyIframe === 'undefined') {
            console.error('Daily.js failed to load. Check the script URL.');
            return;
        }

        let callFrame = null;
        try {
            // Create and join the call frame
            callFrame = window.DailyIframe.createFrame(callElement, {
                iframeStyle: {
                    border: '0',
                    width: '100%',
                    height: '100%',
                }
            });
            if (!roomUrl) {
                console.error('No room URL provided.');
                return;
            }
            callFrame.join({ url: roomUrl }).catch(error => {
                console.error('Failed to join call:', error);
            });
        } catch (error) {
            console.error('Error creating call frame:', error);
            return;
        }

        const endCallButton = document.getElementById('end-call');
        if (endCallButton) {
            endCallButton.addEventListener('click', function() {
                if (confirm('Are you sure you want to end the call?')) {
                    if (callFrame) {
                        callFrame.leave().then(() => {
                            const isUser = '{{ auth()->user()->role ?? 'user' }}' === 'user';
                            const redirectRoute = isUser ? '{{ route('appointment.review', ':id') }}'.replace(':id', {{ $appointment->id }}) : '{{ route('appointment.feedback', ':id') }}'.replace(':id', {{ $appointment->id }});
                            window.location.href = redirectRoute;
                        }).catch(error => {
                            console.error('Error leaving call:', error);
                            // Fallback redirection
                            const isUser = '{{ auth()->user()->role ?? 'user' }}' === 'user';
                            const redirectRoute = isUser ? '{{ route('appointment.review', ':id') }}'.replace(':id', {{ $appointment->id }}) : '{{ route('appointment.feedback', ':id') }}'.replace(':id', {{ $appointment->id }});
                            window.location.href = redirectRoute;
                        });
                    } else {
                        console.warn('Call frame not available, redirecting anyway.');
                        const isUser = '{{ auth()->user()->role ?? 'user' }}' === 'user';
                        const redirectRoute = isUser ? '{{ route('appointment.review', ':id') }}'.replace(':id', {{ $appointment->id }}) : '{{ route('appointment.feedback', ':id') }}'.replace(':id', {{ $appointment->id }});
                        window.location.href = redirectRoute;
                    }
                }
            });
        }
    });
</script>