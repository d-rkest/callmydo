@extends('layouts.app')

@section('title', 'Medical History')
@section('navbar-title', 'Medical History')

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
                <span class="text-gray-500">Medical History</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Medical History</h2>

    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow">
        <!-- Call History -->
        <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Call History</h3>
        <div class="overflow-x-auto mb-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-green-200">
                        <th class="p-2 border-b">Date</th>
                        <th class="p-2 border-b">Time</th>
                        <th class="p-2 border-b">Doctor</th>
                        <th class="p-2 border-b">Status</th>
                        <th class="p-2 border-b">Duration</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($callHistory as $call)
                        <tr class="border-b">
                            <td class="p-2">{{ $call['date'] }}</td>
                            <td class="p-2">{{ $call['time'] }}</td>
                            <td class="p-2">{{ $call['doctor'] }}</td>
                            <td class="p-2">
                                @switch($call['status'])
                                    @case('calling')
                                        <span class="bg-red-100 text-sm p-1 px-3 rounded-full text-red-800">failed</span>
                                        @break
                                    @case('accepted')
                                        <span class="bg-green-100 p-1 px-3 rounded text-green-800">accepted</span>
                                        @break
                                    @default
                                        <span class="bg-yellow-100 p-1 px-3 rounded text-yellow-800">pending</span>
                                @endswitch
                            </td>
                            <td class="p-2">{{ $call['notes'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Appointment History -->
        <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Appointment History</h3>
        <div class="overflow-x-auto mb-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-green-200">
                        <th class="p-2 border-b">Date</th>
                        <th class="p-2 border-b">Time</th>
                        <th class="p-2 border-b">Doctor</th>
                        <th class="p-2 border-b">Status</th>
                        <th class="p-2 border-b">Reason</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointmentHistory as $appointment)
                        <tr class="border-b">
                            <td class="p-2">{{ $appointment['date'] }}</td>
                            <td class="p-2">{{ $appointment['time'] }}</td>
                            <td class="p-2">{{ $appointment['doctor'] }}</td>
                            <td class="p-2">                               
                                @switch($appointment['status'])
                                    @case('expired')
                                        <span class="bg-red-300 text-sm p-1 px-3 rounded-full text-red-800">expired</span>
                                        @break
                                    @case('scheduled')
                                        <span class="bg-yellow-200 text-sm p-1 px-3 rounded-full text-yellow-800">approved</span>
                                        @break
                                    @case('successful')
                                        <span class="bg-green-200 text-sm p-1 px-3 rounded-full text-green-800">successful</span>
                                        @break
                                    @default
                                        <span class="bg-gray-200 text-sm p-1 px-3 rounded-full text-gray-800">pending approval</span>
                                @endswitch
                            </td>
                            <td class="p-2">{{ $appointment['reason'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Medical Reports History -->
        <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Medical Reports History</h3>
        <div class="space-y-4">
            @foreach ($medicalReports as $report)
                <p>
                    <strong>Report ID:</strong> {{ $report['type'] }} | 
                    <strong>Date:</strong> {{ $report['date'] }} | 
                    <strong>Doctor:</strong> {{ $report['doctor'] }}
                </p>
            @endforeach
        </div>
    </div>
@endsection