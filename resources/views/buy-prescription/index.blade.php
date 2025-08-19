@extends('layouts.app')

@section('title', 'Buy Prescription')
@section('navbar-title', 'Buy Prescription')

@section('sidebar-menu')
    @component('components.user-menu') @endcomponent
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">Buy Prescription</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Buy Prescription</h2>

    <div class="md:ml-64 lg:ml-0">
        <div class="max-w-2xl bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Card Header/Title Section -->
            <div class="bg-blue-600 text-white p-4">
                <div class="flex justify-between text-sm">
                    <p><span class="font-bold">From:</span> Dr. Claire Brown</p>
                    <p class="font-bold">X-Ray Scan</p>
                    <p>Date: {{ now()->format('F d, Y') }}</p>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-6">
                <h4 class="text-md font-semibold mb-4">Prescribed Medications</h4>
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b pb-2">
                        <div class="flex-1">
                            <p class="font-medium">Diclofenac</p>
                            <p class="text-sm text-gray-600">500mg for 7 days, twice daily</p>
                        </div>
                        <p class="text-sm font-semibold ml-4">₦{{ '2400' }}</p>
                    </div>
                    <!-- Add more prescription rows here if needed -->
                </div>
            </div>

            <!-- Card Footer -->
            <div class="p-6 bg-gray-50 border-t">
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="radio" name="delivery_option" value="pickup" class="mr-2" checked>
                        <span>Pickup (Free)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="delivery_option" value="delivery" class="mr-2">
                        <span>Delivery (+₦500)</span>
                    </label>
                    <a href="{{ route('checkout', 1) }}" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300">Place Order</a>
                </div>
            </div>
        </div>
    </div>
@endsection