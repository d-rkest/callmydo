@extends('layouts.app')

@section('title', 'Dashboard')
@section('navbar-title', 'Dashboard')

@section('sidebar-menu')
    @component('components.user-menu') @endcomponent
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <span class="text-gray-500">Dashboard</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Dashboard</h2>

    <div class="md:ml-64 lg:ml-0 grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Call A Doctor Card -->
        <div class="bg-white flex flex-col items-center relative sm:col-span-1 bg-gradient-to-br from-blue-100 to-white p-6 rounded-lg shadow-lg">
            <img src="{{ url('images/doctor-call.png') }}" alt="Doctor with Stethoscope" class="w-48 h-48 object-cover border-8 outline-2 outline-offset-2 outline-solid rounded-full">
            <h3 class="text-lg font-bold text-blue-800 mt-4">CALL A DOCTOR</h3>
            <button id="call-doctor" class="mt-4 bg-green-600 text-white p-6 rounded-full flex items-center hover:bg-green-700 transition duration-600 animate-broadcast">
                <svg class="w-10 h-10 animate-vibrate" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
            </button>
        </div>

        <!-- List of Appointments Card -->
        <div class="sm:col-span-2 bg-gradient-to-br from-green-100 to-white p-6 rounded-lg shadow-lg">
            <div class="text-end">
                <a href="{{ route('appointment.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md mb-4 inline-flex items-center hover:bg-blue-700">
                    <i class="fa fa-calendar-check mr-2"></i>
                    Book Appointment
                </a>
            </div>
            <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">List of Appointments</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-green-200">
                            <th class="p-2 border-b">Date</th>
                            <th class="p-2 border-b">Time</th>
                            <th class="p-2 border-b">Doctor</th>
                            <th class="p-2 border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr class="border-b @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800 @elseif($appointment->status === 'completed') bg-green-100 text-green-800 @elseif($appointment->status === 'expired') bg-red-100 text-red-800 @endif">
                                <td class="p-2">{{ $appointment->appointment_date }}</td>
                                <td class="p-2">{{ $appointment->appointment_time }} WAT</td>
                                <td class="p-2">{{ $appointment->doctor ? $appointment->doctor->name : 'N/A' }}</td>
                                <td class="p-2">{{ $appointment->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('call.waiting')
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const callDoctor = document.getElementById('call-doctor');
        const callWaitingModal = document.getElementById('call-waiting-modal');
        const endCall = document.getElementById('end-call');
        const ringtone = new Audio("{{ url('sounds/telephone-ring-02.mp3') }}");

        if (callDoctor && callWaitingModal && endCall) {
            callDoctor.addEventListener('click', function() {
                fetch('{{ route('call.initiate') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        callWaitingModal.classList.remove('hidden');
                        ringtone.loop = true;
                        ringtone.play().catch(error => console.log('Audio play failed:', error));
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error initiating call:', error));
            });

            endCall.addEventListener('click', function() {
                callWaitingModal.classList.add('hidden');
                ringtone.pause();
                ringtone.currentTime = 0;
                fetch('{{ route('call.cancel') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ call_id: data.call_id }) // Assuming call_id is stored from initiateCall response
                }).catch(error => console.error('Error canceling call:', error));
            });
        }

        // Listen for call acceptance
        window.Echo.private(`user.${{Auth::id()}}`)
            .listen('CallAcceptedEvent', (e) => {
                const callWaitingModal = document.getElementById('call-waiting-modal');
                if (callWaitingModal) {
                    callWaitingModal.classList.add('hidden');
                    ringtone.pause();
                    ringtone.currentTime = 0;
                    window.location.href = '{{ route('call.video', ':id') }}'.replace(':id', e.callId);
                }
            });
    });
</script>

<style>
    .animate-broadcast {
        animation: broadcast 2s infinite;
    }

    .animate-vibrate {
        animation: vibrate 0.5s infinite alternate;
    }

    .animate-waver {
        animation: waver 1s infinite;
    }

    @keyframes broadcast {
        0% { box-shadow: 0 0 0 0 rgba(0, 128, 0, 0.4); }
        40% { box-shadow: 0 0 0 15px rgba(0, 128, 0, 0); }
        80% { box-shadow: 0 0 0 30px rgba(0, 128, 0, 0); }
        100% { box-shadow: 0 0 0 0 rgba(0, 128, 0, 0); }
    }

    @keyframes vibrate {
        0% { transform: translateX(0); }
        25% { transform: translateX(2px); }
        50% { transform: translateX(-2px); }
        75% { transform: translateX(2px); }
        100% { transform: translateX(0); }
    }

    @keyframes waver {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>