@extends('layouts.app')

@section('title', 'Logs')
@section('navbar-title', 'Logs')

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
                <span class="text-gray-500">Logs</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Logs</h2>

    <!-- Logs Filter and Table -->
    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow">
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
                <div class="w-full md:w-1/3">
                    <input type="text" id="search-logs" placeholder="Search by action or user..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>
                <div class="w-full md:w-1/3">
                    <input type="date" id="filter-date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>
                <div class="w-full md:w-1/3">
                    <select id="filter-type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="">All Types</option>
                        <option value="error">Error</option>
                        <option value="info">Info</option>
                        <option value="warning">Warning</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-green-200">
                        <th class="p-2 border-b cursor-pointer" data-sort="timestamp">Timestamp</th>
                        <th class="p-2 border-b cursor-pointer" data-sort="type">Type</th>
                        <th class="p-2 border-b cursor-pointer" data-sort="user">User</th>
                        <th class="p-2 border-b cursor-pointer" data-sort="action">Action</th>
                        <th class="p-2 border-b">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="p-2">2025-08-09 07:00 PM WAT</td>
                        <td class="p-2">Info</td>
                        <td class="p-2">Dr. Jane Smith</td>
                        <td class="p-2">Report Analyzed</td>
                        <td class="p-2">Blood Test - John Doe</td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-2">2025-08-09 06:30 PM WAT</td>
                        <td class="p-2">Warning</td>
                        <td class="p-2">Admin</td>
                        <td class="p-2">User Login Failed</td>
                        <td class="p-2">Invalid credentials</td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-2">2025-08-08 09:15 AM WAT</td>
                        <td class="p-2">Error</td>
                        <td class="p-2">System</td>
                        <td class="p-2">Database Connection</td>
                        <td class="p-2">Connection timeout</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let sortDirection = 1;
        let lastSortedColumn = null;

        document.querySelectorAll('th[data-sort]').forEach(header => {
            header.addEventListener('click', function() {
                const key = this.getAttribute('data-sort');
                const tableRows = Array.from(document.querySelectorAll('tbody tr'));

                if (lastSortedColumn === key) {
                    sortDirection *= -1;
                } else {
                    sortDirection = 1;
                    lastSortedColumn = key;
                }

                tableRows.sort((a, b) => {
                    const aValue = a.cells[Array.from(header.parentElement.children).indexOf(header)].textContent.trim();
                    const bValue = b.cells[Array.from(header.parentElement.children).indexOf(header)].textContent.trim();
                    return aValue.localeCompare(bValue) * sortDirection;
                });

                const tbody = document.querySelector('tbody');
                tableRows.forEach(row => tbody.appendChild(row));
            });
        });

        // Basic filter
        const searchInput = document.getElementById('search-logs');
        const filterDate = document.getElementById('filter-date');
        const filterType = document.getElementById('filter-type');
        const tableRows = document.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const dateFilter = filterDate.value;
            const typeFilter = filterType.value.toLowerCase();

            tableRows.forEach(row => {
                const timestamp = row.cells[0].textContent.toLowerCase();
                const type = row.cells[1].textContent.toLowerCase();
                const user = row.cells[2].textContent.toLowerCase();
                const action = row.cells[3].textContent.toLowerCase();

                const matchesSearch = timestamp.includes(searchTerm) || user.includes(searchTerm) || action.includes(searchTerm);
                const matchesDate = !dateFilter || timestamp.includes(dateFilter);
                const matchesType = !typeFilter || type === typeFilter;

                row.style.display = matchesSearch && matchesDate && matchesType ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        filterDate.addEventListener('change', filterTable);
        filterType.addEventListener('change', filterTable);
    });
</script>