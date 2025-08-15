@extends('layouts.app')

@section('title', 'Manage Doctors')
@section('navbar-title', 'Manage Doctors')

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
                <span class="text-gray-500">Manage Doctors</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Manage Doctors</h2>

    <!-- Add New Doctor Button -->
    <div class="md:ml-64 lg:ml-0 mb-6">
        <button id="openAddDoctorModal" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Add New Doctor</button>
    </div>

    <!-- Doctors Table -->
    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Doctor List</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-green-200">
                        <th class="p-2 border-b cursor-pointer" data-sort="name">Name</th>
                        <th class="p-2 border-b cursor-pointer" data-sort="email">Email</th>
                        <th class="p-2 border-b cursor-pointer" data-sort="specialization">Specialization</th>
                        <th class="p-2 border-b cursor-pointer" data-sort="status">Status</th>
                        <th class="p-2 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctors as $doctor)
                        <tr class="border-b">
                            <td class="p-2">{{ $doctor->name }}</td>
                            <td class="p-2">{{ $doctor->email }}</td>
                            <td class="p-2">{{ $doctor->doctorDetail->specialization ?? 'N/A' }}</td>
                            <td class="p-2">{{ ucfirst($doctor->status) }}</td>
                            <td class="p-2">
                                <a href="{{ route('admin.edit-doctor', $doctor->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                <form action="{{ route('admin.destroy-doctor', $doctor->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this doctor?');">
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

    <!-- Add Doctor Modal -->
    <div id="addDoctorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50" aria-hidden="true">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl overflow-y-auto" style="max-height: 80vh;">
                <h3 class="text-lg font-bold text-green-800 mb-4 border-b-2 border-green-300 pb-1">Add New Doctor</h3>
                <form action="{{ route('admin.store-doctor') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="specialization" class="block text-sm font-medium text-gray-700">Specialization</label>
                            <input type="text" id="specialization" name="specialization" value="{{ old('specialization') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 @error('specialization') border-red-500 @enderror">
                            @error('specialization')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="license_number" class="block text-sm font-medium text-gray-700">License Number</label>
                            <input type="text" id="license_number" name="license_number" value="{{ old('license_number') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 @error('license_number') border-red-500 @enderror">
                            @error('license_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" id="address" name="address" value="{{ old('address') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 @error('address') border-red-500 @enderror">
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 @error('status') border-red-500 @enderror">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="profile_photo" class="block text-sm font-medium text-gray-700">Profile Photo</label>
                            <input type="file" id="profile_photo" name="profile_photo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 @error('profile_photo') border-red-500 @enderror">
                            @error('profile_photo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" id="password" name="password" value="{{ old('password', 'password123') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 @error('password') border-red-500 @enderror">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-end space-x-4 mt-4">
                        <button type="button" id="closeAddDoctorModal" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Cancel</button>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Add Doctor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let sortDirection = 1;
        let lastSortedColumn = null;

        // Modal Toggle
        const openModalBtn = document.getElementById('openAddDoctorModal');
        const closeModalBtn = document.getElementById('closeAddDoctorModal');
        const modal = document.getElementById('addDoctorModal');

        openModalBtn.addEventListener('click', function() {
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
        });

        closeModalBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
        });

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
            }
        });

        // Table Sorting
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
    });
</script>