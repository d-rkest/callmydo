@extends('layouts.app')

@section('title', 'Analytics')
@section('navbar-title', 'Analytics')

@section('sidebar-menu')
    @component('components.admin-menu') @endcomponent
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">Admin Dashboard</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">Analytics</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Analytics</h2>

    <!-- Analytics Dashboard -->
    <div class="md:ml-64 lg:ml-0 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- User Growth Chart -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">User Growth</h3>
            <div id="user-growth-chart" class="h-64 bg-gray-100 rounded-md flex items-center justify-center">
                <p class="text-gray-500">Chart Placeholder (e.g., Line Chart)</p>
            </div>
        </div>

        <!-- Appointment Trends -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Appointment Trends</h3>
            <div id="appointment-trends-chart" class="h-64 bg-gray-100 rounded-md flex items-center justify-center">
                <p class="text-gray-500">Chart Placeholder (e.g., Bar Chart)</p>
            </div>
        </div>

        <!-- Revenue Overview -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold text-yellow-800 mb-2 border-b-2 border-yellow-300 pb-1">Revenue Overview</h3>
            <div id="revenue-overview-chart" class="h-64 bg-gray-100 rounded-md flex items-center justify-center">
                <p class="text-gray-500">Chart Placeholder (e.g., Pie Chart)</p>
            </div>
        </div>

        <!-- Activity Heatmap -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold text-red-800 mb-2 border-b-2 border-red-300 pb-1">Activity Heatmap</h3>
            <div id="activity-heatmap" class="h-64 bg-gray-100 rounded-md flex items-center justify-center">
                <p class="text-gray-500">Heatmap Placeholder</p>
            </div>
        </div>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Placeholder for Chart.js integration
        const ctx1 = document.getElementById('user-growth-chart').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['2025-08-01', '2025-08-02', '2025-08-03', '2025-08-04', '2025-08-05'],
                datasets: [{
                    label: 'Users',
                    data: [10, 20, 15, 30, 25],
                    borderColor: 'rgb(59, 130, 246)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const ctx2 = document.getElementById('appointment-trends-chart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['2025-08-01', '2025-08-02', '2025-08-03', '2025-08-04', '2025-08-05'],
                datasets: [{
                    label: 'Appointments',
                    data: [5, 10, 8, 15, 12],
                    backgroundColor: 'rgb(34, 197, 94)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const ctx3 = document.getElementById('revenue-overview-chart').getContext('2d');
        new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: ['Consultations', 'Payments', 'Other'],
                datasets: [{
                    data: [40, 30, 30],
                    backgroundColor: ['rgb(245, 158, 11)', 'rgb(239, 68, 68)', 'rgb(147, 51, 234)']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Note: Heatmap requires a library like Chart.js with heatmap plugin or custom implementation
        // Placeholder text used for now
    });
</script>