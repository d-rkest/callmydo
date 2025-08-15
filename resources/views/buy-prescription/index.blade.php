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

    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow text-center">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Coming Soon</h3>
        <p class="text-gray-600">This feature is under development and will be available soon. Stay tuned!</p>
        <div class="mt-6">
            <a href="{{ route('medical-report') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Back to Report Details</a>
        </div>
    </div>
@endsection