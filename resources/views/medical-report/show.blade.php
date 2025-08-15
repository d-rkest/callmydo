@extends('layouts.app')

@section('title', 'Medical Report Details')
@section('navbar-title', 'Report Details')

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
                <a href="{{ route('medical-report') }}" class="text-blue-600 hover:text-blue-800">Medical Report</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">Report Details</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Medical Report Details</h2>

    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Report Details</h3>
        <div class="grid grid-cols-2 gap-4">
            <!-- Report Details (col-span-2) -->
            <div class="col-span-2">
                <div class="grid grid-cols-1 gap-2">
                    <div class="bg-gray-100 p-3 rounded-md">
                        <strong class="text-gray-700">Report Type:</strong> {{ $report->report_type }}
                    </div>
                    <div class="bg-gray-100 p-3 rounded-md">
                        <strong class="text-gray-700">Date:</strong> {{ $report->created_at->format('Y-m-d') }}
                    </div>
                    <div class="bg-gray-100 p-3 rounded-md">
                        <strong class="text-gray-700">Findings and Observations:</strong> {{ $report->findings ?? 'N/A' }}
                    </div>
                    <div class="bg-gray-100 p-3 rounded-md">
                        <strong class="text-gray-700">Diagnosis/Condition Identified:</strong> {{ $report->diagnosis ?? 'N/A' }}
                    </div>
                    <div class="bg-gray-100 p-3 rounded-md">
                        <strong class="text-gray-700">Possible Cause:</strong> {{ $report->cause ?? 'N/A' }}
                    </div>
                    <div class="bg-gray-100 p-3 rounded-md">
                        <strong class="text-gray-700">Treatment Plan:</strong> {{ $report->treatment_plan ?? 'N/A' }}
                    </div>
                    <div class="bg-gray-100 p-3 rounded-md">
                        <strong class="text-gray-700">Notes and Comments:</strong> {{ $report->notes ?? 'N/A' }}
                    </div>
                </div>
            </div>

            <!-- Required Medication Card (col-span-1) -->
            <div class="col-span-1 sm:col-span-auto bg-green-100 p-4 rounded-lg shadow">
                <h4 class="text-md font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Required Medications</h4>
                <ul class="list-disc pl-5 mb-4">
                    @foreach ($report->medications as $medication)
                        <li>{{ $medication->name }} <span>({{ $medication->pivot->dosage }})</span></li>
                    @endforeach
                </ul>
                <a href="{{ route('buy-prescription', $report->id) }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Purchase</a>
            </div>
        </div>
    </div>

    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow mt-6">
        <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Doctor Details</h3>
        <p><strong>Name:</strong> {{ $report->doctor ? $report->doctor->name : 'N/A' }}</p>
        <p><strong>Signature:</strong> [Digital Signature Placeholder]</p>
    </div>
@endsection