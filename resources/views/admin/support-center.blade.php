@extends('layouts.app')

@section('title', 'Support Center')
@section('navbar-title', 'Support Center')

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
                <span class="text-gray-500">Support Center</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Support Center</h2>

    <!-- Filter and Search Section -->
    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
            <div class="w-full md:w-1/3">
                <input type="text" id="search-tickets" placeholder="Search by subject or user..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
            </div>
            <div class="w-full md:w-1/3">
                <select id="filter-status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                    <option value="">All Statuses</option>
                    <option value="open">Open</option>
                    <option value="in_progress">In Progress</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
            <div class="w-full md:w-1/3">
                <input type="date" id="filter-date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
            </div>
        </div>
    </div>

    <!-- Tickets Table -->
    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Support Tickets</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-green-200">
                        <th class="p-2 border-b cursor-pointer" data-sort="ticket_id">Ticket ID</th>
                        <th class="p-2 border-b cursor-pointer" data-sort="subject">Subject</th>
                        <th class="p-2 border-b cursor-pointer" data-sort="user">User</th>
                        <th class="p-2 border-b cursor-pointer" data-sort="status">Status</th>
                        <th class="p-2 border-b cursor-pointer" data-sort="created_at">Created At</th>
                        <th class="p-2 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="p-2">#001</td>
                        <td class="p-2">Login Issue</td>
                        <td class="p-2">John Doe</td>
                        <td class="p-2">Open</td>
                        <td class="p-2">2025-08-09 02:00 PM WAT</td>
                        <td class="p-2">
                            <a href="{{ route('admin.view-ticket', 1) }}" class="text-blue-600 hover:text-blue-800">View</a>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-2">#002</td>
                        <td class="p-2">Payment Error</td>
                        <td class="p-2">Dr. Jane Smith</td>
                        <td class="p-2">In Progress</td>
                        <td class="p-2">2025-08-08 10:30 AM WAT</td>
                        <td class="p-2">
                            <a href="{{ route('admin.view-ticket', 2) }}" class="text-blue-600 hover:text-blue-800">View</a>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-2">#003</td>
                        <td class="p-2">Report Not Found</td>
                        <td class="p-2">Alice Johnson</td>
                        <td class="p-2">Closed</td>
                        <td class="p-2">2025-08-07 09:15 AM WAT</td>
                        <td class="p-2">
                            <a href="{{ route('admin.view-ticket', 3) }}" class="text-blue-600 hover:text-blue-800">View</a>
                        </td>
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
        const searchInput = document.getElementById('search-tickets');
        const filterStatus = document.getElementById('filter-status');
        const filterDate = document.getElementById('filter-date');
        const tableRows = document.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusFilter = filterStatus.value.toLowerCase();
            const dateFilter = filterDate.value;

            tableRows.forEach(row => {
                const subject = row.cells[1].textContent.toLowerCase();
                const user = row.cells[2].textContent.toLowerCase();
                const status = row.cells[3].textContent.toLowerCase();
                const createdAt = row.cells[4].textContent;

                const matchesSearch = subject.includes(searchTerm) || user.includes(searchTerm);
                const matchesStatus = !statusFilter || status === statusFilter;
                const matchesDate = !dateFilter || createdAt.includes(dateFilter);

                row.style.display = matchesSearch && matchesStatus && matchesDate ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        filterStatus.addEventListener('change', filterTable);
        filterDate.addEventListener('change', filterTable);
    });
</script>