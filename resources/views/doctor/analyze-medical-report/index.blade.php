@extends('layouts.app')

@section('title', 'Analyze Medical Report')
@section('navbar-title', 'Analyze Medical Report')

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
                <span class="text-gray-500">Analyze Medical Report</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Analyze Medical Report</h2>

    <!-- Link to Schedule History -->
    <div class="relative text-end m-4 md:ml-64 lg:ml-0 mt-6">
        <a href="{{ route('analyzed-reports') }}" class="text-blue-600 hover:text-blue-800 font-medium">View Analyzed Reports</a>
    </div>

    <!-- New Report Requests Card -->
    <div class="md:ml-64 lg:ml-0 bg-gradient-to-br from-green-100 to-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">New Report Requests</h3>
        <!-- Filter -->
        <div class="mb-4">
            <select id="filter-reports" class="border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                <option value="latest">Latest Reports</option>
                <option value="old">Old Reports</option>
            </select>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-green-200">
                        <th class="p-2 border-b">Title</th>
                        <th class="p-2 border-b">User</th>
                        <th class="p-2 border-b">Date</th>
                        <th class="p-2 border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                        <tr class="border-b">
                            <td class="p-2">{{ $report->report_type }} - {{ $report->created_at->format('Y-m-d') }}</td>
                            <td class="p-2">{{ $report->user->name }}</td>
                            <td class="p-2">{{ $report->created_at->format('Y-m-d') }}</td>
                            <td class="p-2"><a href="{{ route('analyze-medical-report.show', $report->id) }}" class="text-blue-600 hover:text-blue-800">Give Feedback</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<script>
    document.getElementById('filter-reports').addEventListener('change', function() {
        const filter = this.value;
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const date = new Date(row.cells[2].textContent);
            const isLatest = date > new Date('2025-08-01');
            row.style.display = filter === 'latest' ? (isLatest ? '' : 'none') : '';
        });
    });
</script>