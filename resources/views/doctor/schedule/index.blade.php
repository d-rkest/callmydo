@extends('layouts.app')

@section('title', 'Schedule')
@section('navbar-title', 'Schedule')

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
                <span class="text-gray-500">Schedule</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Schedule</h2>

    <!-- Link to Schedule History -->
    <div class="relative text-end m-4 md:ml-64 lg:ml-0 mt-6 underline decoration-sky-500">
        <a href="{{ route('schedule.history') }}" class="text-blue-600 hover:text-blue-800 font-medium">My Schedule - History</a>
    </div>

    <div class="md:ml-64 lg:ml-0 grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Upcoming Schedule Card (1 col) -->
        <div class="sm:col-span-1 bg-gradient-to-br from-blue-100 to-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Upcoming Schedule</h3>
            <div class="space-y-2 mt-4 p-5 border rounded border-dotted">
                @if ($upcoming)
                    <p><strong>Date:</strong> {{ $upcoming->appointment_date }}</p>
                    <p><strong>Time:</strong> {{ $upcoming->appointment_time }} WAT</p>
                    <p><strong>Patient:</strong> {{ $upcoming->user->name }}</p>
                    <p><strong>Reason:</strong> {{ $upcoming->reason ?? 'N/A' }}</p>
                    <span class="flex justify-center">
                        <a href="{{ route('appointment.video-call', $upcoming->id) }}" class="mx-auto mt-5 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                            <i class="fa fa-phone text-white"></i> Start Call
                        </a>
                    </span>
                @else
                    <p class="text-gray-500">No upcoming appointments within 15 minutes.</p>
                @endif
            </div>
        </div>

        <!-- Custom Schedule Calendar (2 cols) -->
        <div class="sm:col-span-2 bg-gradient-to-br from-green-100 to-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">My Schedule Calendar</h3>
            <div id="custom-calendar" class="w-full h-96 overflow-y-auto"></div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Notification for call (simulated popup)
        const now = new Date();
        @if ($upcoming)
            const appointmentTime = new Date('{{ $upcoming->appointment_date }} {{ $upcoming->appointment_time }} WAT');
            if (appointmentTime - now < 5 * 60 * 1000 && appointmentTime > now) { // 5 minutes before
                if (!localStorage.getItem('callNotificationShown')) {
                    alert('Join your video call with {{ $upcoming->user->name }} now!');
                    localStorage.setItem('callNotificationShown', 'true');
                }
            }
        @endif

        // Custom Calendar Implementation
        const calendar = document.getElementById('custom-calendar');
        const appointments = @json($appointments);

        // Generate calendar for the current month
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        let calendarHtml = '<table class="w-full border-collapse"><thead><tr class="bg-green-200"><th class="p-2 border-b">Sun</th><th class="p-2 border-b">Mon</th><th class="p-2 border-b">Tue</th><th class="p-2 border-b">Wed</th><th class="p-2 border-b">Thu</th><th class="p-2 border-b">Fri</th><th class="p-2 border-b">Sat</th></tr></thead><tbody>';

        const firstDay = new Date(year, month, 1).getDay();
        let date = 1;
        for (let i = 0; i < 6; i++) {
            calendarHtml += '<tr>';
            for (let j = 0; j < 7; j++) {
                if (i === 0 && j < firstDay) {
                    calendarHtml += '<td class="p-2 border"></td>';
                } else if (date > daysInMonth) {
                    calendarHtml += '<td class="p-2 border"></td>';
                } else {
                    const currentDay = new Date(year, month, date);
                    const dayAppointments = appointments.filter(app => {
                        const appDate = new Date(app.appointment_date);
                        return appDate.toDateString() === currentDay.toDateString();
                    });
                    let content = `<div class="text-center">${date}</div>`;
                    if (dayAppointments.length > 0) {
                        content += '<ul class="text-sm text-blue-800">';
                        dayAppointments.forEach(app => {
                            content += `<li><a href="{{ route('schedule.show', ':id') }}".replace(':id', ${app.id}) class="text-blue-600 hover:text-blue-800">${app.appointment_time}</a></li>`;
                        });
                        content += '</ul>';
                    }
                    calendarHtml += `<td class="p-2 border ${currentDay < now ? 'bg-gray-200' : ''}">${content}</td>`;
                    date++;
                }
            }
            calendarHtml += '</tr>';
        }
        calendarHtml += '</tbody></table>';
        calendar.innerHTML = calendarHtml;
    });
</script>