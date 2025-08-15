@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('navbar-title', 'Admin Dashboard')

@section('sidebar-menu')
    @component('components.admin-menu') @endcomponent
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <span class="text-gray-500">Admin Dashboard</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Admin Dashboard</h2>

    <!-- Metrics Cards -->
    <div class="md:ml-64 lg:ml-0 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-blue-100 p-4 rounded-lg shadow text-center">
            <h3 class="text-lg font-bold text-blue-800">Total Doctors</h3>
            <p class="text-2xl font-semibold mt-2">25</p>
        </div>
        <div class="bg-green-100 p-4 rounded-lg shadow text-center">
            <h3 class="text-lg font-bold text-green-800">Total Patients</h3>
            <p class="text-2xl font-semibold mt-2">150</p>
        </div>
        <div class="bg-yellow-100 p-4 rounded-lg shadow text-center">
            <h3 class="text-lg font-bold text-yellow-800">Pending Reports</h3>
            <p class="text-2xl font-semibold mt-2">8</p>
        </div>
        <div class="bg-red-100 p-4 rounded-lg shadow text-center">
            <h3 class="text-lg font-bold text-red-800">Total Transactions</h3>
            <p class="text-2xl font-semibold mt-2">320</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="md:ml-64 lg:ml-0 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activities -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Recent Activities</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-blue-200">
                            <th class="p-2 border-b">Date</th>
                            <th class="p-2 border-b">Action</th>
                            <th class="p-2 border-b">User</th>
                            <th class="p-2 border-b">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="p-2">2025-08-09</td>
                            <td class="p-2">Report Analyzed</td>
                            <td class="p-2">Dr. Jane Smith</td>
                            <td class="p-2">Blood Test - John Doe</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-2">2025-08-08</td>
                            <td class="p-2">User Registered</td>
                            <td class="p-2">John Doe</td>
                            <td class="p-2">New patient account</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-2">2025-08-07</td>
                            <td class="p-2">Payment Processed</td>
                            <td class="p-2">Dr. John Doe</td>
                            <td class="p-2">NGN 5,000.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- User Management -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">User Management</h3>
            <div class="mb-4">
                <input type="text" id="search-users" placeholder="Search users..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-green-200">
                            <th class="p-2 border-b">Name</th>
                            <th class="p-2 border-b">Role</th>
                            <th class="p-2 border-b">Email</th>
                            <th class="p-2 border-b">Status</th>
                            <th class="p-2 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="p-2">Dr. Jane Smith</td>
                            <td class="p-2">Doctor</td>
                            <td class="p-2">jane.smith@example.com</td>
                            <td class="p-2">Active</td>
                            <td class="p-2">
                                <a href="{{ route('admin.edit-user', 1) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                <a href="#" class="text-red-600 hover:text-red-800 ml-2">Delete</a>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-2">John Doe</td>
                            <td class="p-2">Patient</td>
                            <td class="p-2">john.doe@example.com</td>
                            <td class="p-2">Active</td>
                            <td class="p-2">
                                <a href="{{ route('admin.edit-user', 2) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                <a href="#" class="text-red-600 hover:text-red-800 ml-2">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection