@extends('layouts.app')

@section('title', 'Schedule History')
@section('navbar-title', 'Schedule History')

@section('sidebar-menu')
    @component('components.doctor-menu') @endcomponent
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('doctor.dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <a href="{{ route('schedule.index') }}" class="text-blue-600 hover:text-blue-800">Schedule</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">History</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Schedule History</h2>

    <div class="md:ml-64 lg:ml-0 overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-green-200">
                    <th class="p-2 border-b">Date</th>
                    <th class="p-2 border-b">Time</th>
                    <th class="p-2 border-b">Patient</th>
                    <th class="p-2 border-b">Status</th>
                    <th class="p-2 border-b">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($history as $appointment)
                    <tr class="border-b @if($appointment->status === 'completed') bg-green-100 text-green-800 @elseif($appointment->status === 'expired') bg-red-100 text-red-800 @endif">
                        <td class="p-2">{{ $appointment->appointment_date }}</td>
                        <td class="p-2">{{ $appointment->appointment_time }} WAT</td>
                        <td class="p-2">{{ $appointment->user->name }}</td>
                        <td class="p-2">{{ $appointment->status }}</td>
                        <td class="p-2"><a href="{{ route('schedule.show', $appointment->id) }}" class="text-blue-600 hover:text-blue-800">View Details</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection