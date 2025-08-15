@extends('layouts.app')

@section('title', 'Doctor Dashboard')
@section('navbar-title', 'Doctor Dashboard')

@section('sidebar-menu')
    @component('components.doctor-menu') @endcomponent
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <span class="text-gray-500">Doctor Dashboard</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Doctor Dashboard</h2>

    <!-- Dashboard Cards -->
    <div class="md:ml-64 lg:ml-0 grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-100 p-3 rounded-lg shadow text-left flex items-center h-24">
            <i class="fa fa-table text-blue-800 text-6xl mr-6" aria-hidden="true"></i>
            <div>
                <h3 class="text-md font-bold text-blue-800">New Appointments</h3>
                <div class="flex">
                    <p class="text-4xl font-semibold mt-1 mr-4">{{ $newAppointments }}</p>
                    <a href="{{ route('schedule.appointment') }}" class="mt-2 inline-block bg-blue-600 text-white px-2 py-1 rounded-full text-sm hover:bg-blue-700">View</a>
                </div>
            </div>
        </div>
        <div class="bg-green-100 p-3 rounded-lg shadow text-left flex items-center h-24">
            <i class="fa fa-calendar text-green-800 text-6xl mr-6" aria-hidden="true"></i>
            <div>
                <h3 class="text-md font-bold text-green-800">My Schedule</h3>
                <div class="flex">
                    <p class="text-4xl font-semibold mt-1 mr-4">{{ $scheduleCount }}</p>
                    <a href="{{ route('schedule.index') }}" class="mt-2 inline-block bg-green-600 text-white px-2 py-1 rounded-full text-sm hover:bg-green-700">View</a>
                </div>
            </div>
        </div>
        <div class="bg-purple-100 p-3 rounded-lg shadow text-left flex items-center h-24">
            <i class="fa fa-file-text text-purple-800 text-6xl mr-6" aria-hidden="true"></i>
            <div>
                <h3 class="text-md font-bold text-purple-800">Medical Reports</h3>
                <div class="flex">
                    <p class="text-4xl font-semibold mt-1 mr-4">{{ $medicalReports }}</p>
                    <a href="{{ route('analyze-medical-report') }}" class="mt-2 inline-block bg-purple-600 text-white px-2 py-1 rounded-full text-sm hover:bg-purple-700">View</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="md:ml-64 lg:ml-0 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Appointment Column (Left) -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">New Appointments</h3>
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
                            <th class="p-2 border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr class="border-b @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800 @endif">
                                <td class="p-2">{{ $appointment->appointment_date }}</td>
                                <td class="p-2">{{ $appointment->appointment_time }} WAT</td>
                                <td class="p-2">{{ $appointment->user->name }}</td>
                                <td class="p-2"><a href="{{ route('schedule.show', $appointment->id) }}" class="text-blue-600 hover:text-blue-800">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Table Column (Right) -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">New Medical Reports</h3>
            <div class="mb-4">
                <select id="filter-reports" class="border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                    <option value="latest">Latest Reports</option>
                    <option value="old">Oldest Reports</option>
                </select>
            </div>
            <div class="overflow-x-auto">
                <table id="data-table" class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-green-200">
                            <th class="p-2 border-b cursor-pointer" data-sort="date">Date</th>
                            <th class="p-2 border-b cursor-pointer" data-sort="time">Title</th>
                            <th class="p-2 border-b cursor-pointer" data-sort="name">Name</th>
                            <th class="p-2 border-b cursor-pointer" data-sort="status">Status</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @foreach ($reports as $report)
                            <tr class="border-b @if($report->status === 'pending') bg-yellow-100 text-yellow-800 @elseif($report->status === 'analyzed') bg-green-100 text-green-800 @endif">
                                <td class="p-2">{{ $report->created_at->toDateString() }}</td>
                                <td class="p-2">{{ $report->report_type }}</td>
                                <td class="p-2">{{ $report->user->name }}</td>
                                <td class="p-2">{{ $report->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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

    // Filter Reports
    document.getElementById('filter-reports').addEventListener('change', function() {
        const filter = this.value;
        const rows = document.querySelectorAll('#table-body tr');
        rows.forEach(row => {
            const date = new Date(row.cells[0].textContent);
            const isLatest = date >= new Date('{{ now()->toDateString() }}');
            row.style.display = filter === 'latest' ? (isLatest ? '' : 'none') : '';
        });
    });

    // Sortable table for reports
    let sortDirection = 1;
    let lastSortedColumn = null;

    document.querySelectorAll('#data-table th').forEach(header => {
        header.addEventListener('click', function() {
            const key = this.getAttribute('data-sort');
            const rows = Array.from(document.querySelectorAll('#table-body tr')).sort((a, b) => {
                const aValue = a.cells[Array.from(this.parentNode.children).indexOf(this)].textContent;
                const bValue = b.cells[Array.from(this.parentNode.children).indexOf(this)].textContent;
                return aValue.localeCompare(bValue) * sortDirection;
            });

            if (lastSortedColumn === key) {
                sortDirection *= -1;
                rows.reverse();
            } else {
                sortDirection = 1;
                lastSortedColumn = key;
            }

            const tbody = document.getElementById('table-body');
            rows.forEach(row => tbody.appendChild(row));
        });
    });
</script>