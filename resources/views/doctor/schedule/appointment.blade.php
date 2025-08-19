@extends('layouts.app')

@section('title', 'Appointments')
@section('navbar-title', 'All Appointments')

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
                <span class="text-gray-500">Appointments</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">All Appointment</h2>

    <!-- All Appointments Card -->
    <div class="md:ml-64 lg:ml-0 bg-gradient-to-br from-blue-100 to-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">View All Appointments</h3>
        <div class="mb-4">
            <select id="filter-appointments" class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="latest">Latest Appointments</option>
                <option value="old">Old Appointments</option>
            </select>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-blue-200">
                        <th class="p-2 border-b">Date</th>
                        <th class="p-2 border-b">Time</th>
                        <th class="p-2 border-b">Patient</th>
                        <th class="p-2 border-b">Status</th>
                        <th class="p-2 border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appointment)
                        <tr class="border-b @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800 @endif">
                            <td class="p-2">{{ $appointment->appointment_date }}</td>
                            <td class="p-2">{{ $appointment->appointment_time }} WAT</td>
                            <td class="p-2">{{ $appointment->user->name }}</td>
                            <td class="p-2">
                                @switch($appointment->status)
                                    @case('pending')
                                        <span class="text-yellow-600 font-bold bg-yellow-400 rounded-full px-3 py-1 text-sm">Pending</span>
                                        @break
                                    @case('scheduled')
                                        <span class="text-green-600 font-bold rounded-full px-3 py-1 text-sm">Joined</span>                                           
                                        @break
                                    @default
                                        <span class="text-gray-600 font-bold bg-gray-400 rounded-full px-3 py-1 text-sm">Completed</span>
                                @endswitch
                            </td>
                            <td class="p-2"><a href="{{ route('schedule.show', $appointment->id) }}" class="text-blue-600 hover:text-blue-800">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<script>
    // Filter Appointments
    document.getElementById('filter-appointments').addEventListener('change', function() {
        const filter = this.value;
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const date = new Date(row.cells[0].textContent);
            const isLatest = date >= new Date('{{ now()->toDateString() }}');
            row.style.display = filter === 'latest' ? (isLatest ? '' : 'none') : '';
        });
    });
</script>