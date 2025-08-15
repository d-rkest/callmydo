@extends('layouts.app')

@section('title', 'Appointments')
@section('navbar-title', 'Appointments')

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
                <span class="text-gray-500">Appointments</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Appointments</h2>

    <div class="md:ml-64 lg:ml-0 grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Upcoming Appointment Card (1 col) -->
        <div class="sm:col-span-1 bg-gradient-to-br from-blue-100 to-white p-6 rounded-lg shadow-lg">
            <a href="#" class="text-center bg-green-600 text-white font-black px-4 py-2 rounded-md hover:bg-green-700 mb-4 flex items-center justify-center" id="book-appointment">
                <i class="fas fa-calendar-days text-3xl"></i>
                FREE 10-minute Consultation
            </a>
            <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Upcoming Appointment</h3>
            <div class="space-y-2">
                @if ($upcoming)
                    <p><strong>Date:</strong> {{ $upcoming->appointment_date }}</p>
                    <p><strong>Time:</strong> {{ $upcoming->appointment_time }} WAT</p>
                    <p><strong>Doctor:</strong> {{ $upcoming->doctor->name ?? 'Not assigned yet' }}</p>
                    <span class="flex justify-center">
                        <a href="{{ route('appointment.video-call', $upcoming->id) }}" class="mx-auto mt-5 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">Join Call</a>
                    </span>
                @else
                    <p class="text-gray-500">No upcoming appointments.</p>
                @endif
            </div>
        </div>

        <!-- Appointments Table (2 cols) -->
        <div class="sm:col-span-2 bg-gradient-to-br from-green-100 to-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Appointment History</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-green-200">
                            <th class="p-2 border-b">Date/Time</th>
                            <th class="p-2 border-b">Time</th>
                            <th class="p-2 border-b">Doctor</th>
                            <th class="p-2 border-b">Status</th>
                            <th class="p-2 border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr class="border-b @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800 @elseif($appointment->status === 'scheduled') bg-blue-100 text-blue-800 @elseif($appointment->status === 'completed') bg-green-100 text-green-800 @elseif($appointment->status === 'expired') bg-red-100 text-red-800 @endif">
                                <td class="p-2">{{ $appointment->appointment_date }}</td>
                                <td class="p-2">{{ $appointment->appointment_time }} WAT</td>
                                <td class="p-2">{{ $appointment->status === 'pending' ? '-' : ($appointment->doctor->name ?? '-') }}</td>
                                <td class="p-2">{{ $appointment->status }}</td>
                                <td class="p-2">
                                    @if ($appointment->status !== 'pending')
                                        <a href="{{ route('appointment.show', $appointment->id) }}" class="text-blue-600 hover:text-blue-800">View Details</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Appointment Booking Modal -->
    <div id="appointment-modal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden flex items-center justify-center" aria-hidden="true">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Book Appointment</h3>
            <form action="{{ route('appointment.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="appointment_date" class="text-sm font-medium text-gray-700">Date</label>
                    <input type="date" id="appointment_date" name="appointment_date" min="{{ now()->toDateString() }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="appointment_time" class="text-sm font-medium text-gray-700">Time</label>
                    <input type="time" id="appointment_time" name="appointment_time" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="comment" class="text-sm font-medium text-gray-700">Reason for Appointment</label>
                    <textarea id="comment" name="comment" rows="3" placeholder="Describe your reason for the appointment..." class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Book Now</button>
                <button type="button" id="close-modal" class="mt-2 bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Cancel</button>
                <div id="response-message" class="mt-4 text-center text-sm text-gray-600 hidden"></div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookAppointment = document.getElementById('book-appointment');
        if (bookAppointment) {
            bookAppointment.addEventListener('click', function(e) {
                e.preventDefault();
                const modal = document.getElementById('appointment-modal');
                if (modal) {
                    modal.classList.remove('hidden');
                }
            });
        }

        const closeModal = document.getElementById('close-modal');
        if (closeModal) {
            closeModal.addEventListener('click', function() {
                const modal = document.getElementById('appointment-modal');
                if (modal) {
                    modal.classList.add('hidden');
                    const responseMessage = document.getElementById('response-message');
                    if (responseMessage) {
                        responseMessage.classList.add('hidden');
                    }
                }
            });
        }

        // Close modal on outside click
        const appointmentModal = document.getElementById('appointment-modal');
        if (appointmentModal) {
            appointmentModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                    const responseMessage = document.getElementById('response-message');
                    if (responseMessage) {
                        responseMessage.classList.add('hidden');
                    }
                }
            });
        }

        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const responseMessage = document.getElementById('response-message');
                if (responseMessage) {
                    fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            responseMessage.textContent = 'Appointment booked successfully! You will receive a confirmation soon.';
                            responseMessage.classList.remove('hidden', 'text-red-600');
                            responseMessage.classList.add('text-green-600');
                            setTimeout(() => {
                                form.reset();
                                appointmentModal.classList.add('hidden');
                                responseMessage.classList.add('hidden');
                                location.reload();
                            }, 2000);
                        } else {
                            responseMessage.textContent = data.message || 'An error occurred.';
                            responseMessage.classList.remove('hidden', 'text-green-600');
                            responseMessage.classList.add('text-red-600');
                        }
                    })
                    .catch(error => {
                        responseMessage.textContent = 'An error occurred. Please try again.';
                        responseMessage.classList.remove('hidden', 'text-green-600');
                        responseMessage.classList.add('text-red-600');
                    });
                }
            });
        }
    });
</script>