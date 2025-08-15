@extends('layouts.app')

@section('title', 'Manage Users')
@section('navbar-title', 'Manage Users')

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
                <span class="text-gray-500">Manage Users</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Manage Users</h2>

    <!-- Filter and Search Section -->
    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow mb-6">
        <form action="{{ route('admin.users') }}" method="GET" class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
            <div class="w-full md:w-1/3">
                <input type="text" id="search-users" name="search" placeholder="Search by name or email..." value="{{ request('search') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
            </div>
            <div class="w-full md:w-1/3">
                <select id="filter-role" name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                    <option value="">All Roles</option>
                    <option value="doctor" {{ request('role') === 'doctor' ? 'selected' : '' }}>Doctor</option>
                    <option value="patient" {{ request('role') === 'patient' ? 'selected' : '' }}>Patient</option>
                </select>
            </div>
            <div class="w-full md:w-1/3">
                <select id="filter-status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="mt-2 md:mt-0 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Filter</button>
        </form>
    </div>

    <!-- Users Table -->
    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">User List</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-green-200">
                        <th class="p-2 border-b cursor-pointer" data-sort="name">Name</th>
                        <th class="p-2 border-b cursor-pointer" data-sort="role">Role</th>
                        <th class="p-2 border-b cursor-pointer" data-sort="email">Email</th>
                        <th class="p-2 border-b cursor-pointer" data-sort="status">Status</th>
                        <th class="p-2 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b">
                            <td class="p-2">{{ $user->name }}</td>
                            <td class="p-2">{{ ucfirst($user->role) }}</td>
                            <td class="p-2">{{ $user->email }}</td>
                            <td class="p-2">{{ ucfirst($user->status) }}</td>
                            <td class="p-2">
                                <a href="{{ route('admin.edit-user', $user->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                <form action="{{ route('admin.destroy-user', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
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

        // Basic search and filter (client-side)
        const searchInput = document.getElementById('search-users');
        const filterRole = document.getElementById('filter-role');
        const filterStatus = document.getElementById('filter-status');
        const tableRows = document.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const roleFilter = filterRole.value.toLowerCase();
            const statusFilter = filterStatus.value.toLowerCase();

            tableRows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                const role = row.cells[1].textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();
                const status = row.cells[3].textContent.toLowerCase();

                const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                const matchesRole = !roleFilter || role === roleFilter;
                const matchesStatus = !statusFilter || status === statusFilter;

                row.style.display = matchesSearch && matchesRole && matchesStatus ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        filterRole.addEventListener('change', filterTable);
        filterStatus.addEventListener('change', filterTable);
    });
</script>