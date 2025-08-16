@extends('layouts.app')

@section('title', 'My Wallet')
@section('navbar-title', 'My Wallet')

@section('sidebar-menu')
    @component('components.doctor-menu') @endcomponent
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('doctor.dashboard') }}" class="text-blue-600 hover:text-blue-800">Doctor Dashboard</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">My Wallet</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">My Wallet</h2>

    <!-- Wallet Balance Card -->
    <div class="md:ml-64 lg:ml-0 grid grid-cols-1 sm:grid-cols-1 gap-4 mb-6">
        <div class="bg-green-100 p-4 rounded-lg shadow text-center">
            <h3 class="text-lg font-bold text-green-800">Wallet Balance</h3>
            <p class="text-2xl font-semibold mt-2">NGN 00.00</p>
            <a href="{{ route('doctor.fund-wallet') }}" class="mt-4 inline-block bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Fund Wallet</a>
        </div>
    </div>

    <!-- Payment History Table -->
    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Payment History</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-green-200">
                        <th class="p-2 border-b">Date</th>
                        <th class="p-2 border-b">Type</th>
                        <th class="p-2 border-b">Description</th>
                        <th class="p-2 border-b">Amount (NGN)</th>
                        <th class="p-2 border-b">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-2 bg-gray-300 text-center py-8 text-gray-400 font-bold" colspan="5"> No Records</td>
                    </tr>
                    {{-- <tr class="border-b">
                        <td class="p-2">2025-08-07</td>
                        <td class="p-2">Funding</td>
                        <td class="p-2">Card Payment</td>
                        <td class="p-2">5,000.00</td>
                        <td class="p-2">Completed</td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-2">2025-08-06</td>
                        <td class="p-2">User Payment</td>
                        <td class="p-2">Consultation Fee - John Doe</td>
                        <td class="p-2">3,500.00</td>
                        <td class="p-2">Received</td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-2">2025-08-05</td>
                        <td class="p-2">Withdrawal</td>
                        <td class="p-2">Bank Transfer</td>
                        <td class="p-2">2,000.00</td>
                        <td class="p-2">Processed</td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
@endsection